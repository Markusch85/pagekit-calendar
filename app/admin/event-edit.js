$(function(){

    var vm = new Vue({

        el: '#event',

        data: {
            event: window.$data.event,
			authors: window.$data.authors,
			categories: window.$data.categories
        },

        methods: {

            save: function() {

                this.$http.post('api/calendar/events/save', { event: this.event }, function(data) {
					this.$set('$data.event', data.event);
                    UIkit.notify(vm.$trans('Event saved.'));
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            }

        }

    });

});