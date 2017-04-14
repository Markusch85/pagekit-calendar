$(function(){

    var vm = new Vue({

        el: '#appointments',

        data: {
            entries: window.$data.appointments
        },

        methods: {

            remove: function(appointment) {
                this.appointments.$remove(appointment);
            }

        }

    });

});