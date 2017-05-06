<script>

	module.exports = {

        el: '#category',

        data: function () {
            return {
                data: window.$data,
                category: window.$data.category,
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

            this.resource = this.$resource('api/calendar/category{/id}');
        },
        
        methods: {
            save: function () {
                var data = {category: this.category, id: this.category.id};

                this.$broadcast('save', data);

                this.resource.save({id: this.category.id}, data).then(function (res) {

                    var data = res.data;

                    if (!this.category.id) {
                        window.history.replaceState({}, '', this.$url.route('admin/calendar/category/edit', {id: data.category.id}))
                    }

                    this.$set('category', data.category);

                    this.$notify('Category saved.');

                }, function (res) {
                    this.$notify(res.data, 'danger');
                });
            }

        }

    };

    Vue.ready(module.exports);

</script>