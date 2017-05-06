<script>

	module.exports = {

        el: '#events',

        data: function() {
            return _.merge({
                entries: [],
                config: {
                    filter: this.$session.get('events.filter', {order: 'start asc', limit:25})
                },
                selected: [],
                count: '',
                pages: 0
            }, window.$data);
        },

        ready: function () {
            this.resource = this.$resource('api/calendar/event{/id}');
            this.$watch('config.page', this.load, {immediate: true});
        },
        
        watch: {
            'config.filter': {
                handler: function (filter) {
                    if (this.config.page) {
                        this.config.page = 0;
                    } else {
                        this.load();
                    }

                    this.$session.set('events.filter', filter);
                },
                deep: true
            }
        },
        
        computed: {
            statusOptions: function () {

                var options = _.map(this.$data.statuses, function (status, id) {
                    return { text: status, value: id };
                });

                return [{ label: this.$trans('Filter by'), options: options }];
            },

            authors: function() {

                var options = _.map(this.$data.authors, function (author) {
                    return { text: author.username, value: author.user_id };
                });

                return [{ label: this.$trans('Filter by'), options: options }];
            }
        },
        
        methods: {

            load: function () {
                this.resource.query({ filter: this.config.filter, page: this.config.page }).then(function (res) {

                    var data = res.data;

                    this.$set('$data.entries', data.events);
                    this.$set('pages', data.pages);
                    this.$set('count', data.count);
                    this.$set('selected', []);
                });
            },
            
            remove: function() {
                this.$http.post('api/calendar/events/remove', { ids: this.selected }, function() {
                    UIkit.notify(vm.$trans('Events deleted.'));
                    this.load();
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            },
            
            copy: function() {
                if (!this.selected.length) {
                    return;
                }

                this.resource.save({ id: 'copy' }, { ids: this.selected }).then(function () {
                    this.load();
                    this.$notify('Events copied.');
                });
            }
        }

    }

	Vue.ready(module.exports);

</script>