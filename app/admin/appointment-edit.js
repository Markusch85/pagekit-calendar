$(function(){

    var vm = new Vue({

        el: '#appointment',

        data: {
            appointment: window.$data.appointment,
			authors: window.$data.authors,
			categories: window.$data.categories
        },

        methods: {

            save: function() {

                this.$http.post('admin/calendar/appointment/save', { appointment: this.appointment }, function(data, test) {
					this.$set('$data.appointment', data.appointment);
                    UIkit.notify(vm.$trans('Appointment saved.'), '');
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            }

        }

    });

});