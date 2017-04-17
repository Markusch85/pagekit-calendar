$(function(){

    var vm = new Vue({

        el: '#events',

        data: {
            entries: [],
			selected: [],
			count: ''
        },

		ready: function () {
	        this.$watch('', this.load, {immediate: true});
	    },
		
        methods: {

			load: function () {
				this.$http.post('api/calendar/events/load', function(data) {
					this.$set('$data.entries', data.events);
					this.$set('$data.selected', []);
					this.$set('$data.count', data.count);
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
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
                this.$http.post('api/calendar/events/copy', { ids: this.selected }, function() {
                    UIkit.notify(vm.$trans('Events copied.'));
					this.load();
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            }
        }

    });

});