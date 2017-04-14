$(function(){

    var vm = new Vue({

        el: '#appointments',

        data: {
            entries: [],
			selected: [],
			count: ''
        },

		ready: function () {
	        //this.resource = this.$resource('api/gallery{/id}');
	        this.$watch('', this.load, {immediate: true});
	    },
		
        methods: {

			load: function () {
				this.$http.post('admin/calendar/appointments/load', function(data) {
					this.$set('$data.entries', data.$data.appointments);
					this.$set('selected', []);
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
			},
			
            remove: function() {

                this.$http.post('admin/calendar/appointments/remove', { ids: this.selected }, function() {
                    UIkit.notify(vm.$trans('Appointments deleted.'), '');
					this.load();
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            }
        }

    });

});