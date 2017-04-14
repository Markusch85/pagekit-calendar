$(function(){

    var vm = new Vue({

        el: '#categories',

        data: {
            entries: window.$data.categories
        },

        methods: {

            remove: function(category) {
                this.categories.$remove(category);
            }
        }

    });

});