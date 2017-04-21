$(function(){

    new Vue({

        el: '#event',

        data: function () {
            return {
                event: window.$data.event,
                categories: window.$data.categories,
                authors: window.$data.authors
            }
        },
                
        created: function () {
            var sections = [];

            _.forIn(this.$options.components, function (component, name) {

                var options = component.options || {};

                if (options.section) {
                    sections.push(_.extend({name: name, priority: 0}, options.section));
                }

            });

            this.$set('sections', _.sortBy(sections, 'priority'));

            this.resource = this.$resource('api/calendar/event{/id}');
        },

        methods: {

            save: function() {
                
                var data = {event: this.event, id: this.event.id};
                
                var start = this.event.start.replace('.000Z', '').replace('+00:00', '');
                var end = this.event.end.replace('.000Z', '').replace('+00:00', '');
                if (this.event.undefinedEnd) {
                    this.event.end = this.event.start;
                }
                if (end < start) {
                    this.$notify('The start date must be before the end date.');
                    return;
                }
                
                this.$broadcast('save', data);

                this.resource.save({id: this.event.id}, data).then(function (res) {

                    var data = res.data;

                    if (!this.event.id) {
                        window.history.replaceState({}, '', this.$url.route('admin/calendar/event/edit', {id: data.event.id}))
                    }

                    this.$set('event', data.event);

                    this.$notify('Event saved.');

                }, function (res) {
                    this.$notify(res.data, 'danger');
                });
            }

        }

    });

});