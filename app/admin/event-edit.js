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
				var start = this.event.start.replace('.000Z', '').replace('+00:00', '');
				var end = this.event.end.replace('.000Z', '').replace('+00:00', '');
				if (end <= start) {
					UIkit.notify(vm.$trans('The start date must be before the end date.'));
				} else {
					this.$http.post('api/calendar/events/save', { event: this.event }, function(data) {
						this.$set('$data.event', data.event);
						UIkit.notify(vm.$trans('Event saved.'));
					}).error(function(data) {
						UIkit.notify(data, 'danger');
					});
				}
            }

        }

    });

});