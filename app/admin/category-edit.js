$(function(){

    var vm = new Vue({

        el: '#category',

        data: {
            category: window.$data.category,
			authors: window.$data.authors
        },

        methods: {

            save: function() {

                this.$http.post('admin/calendar/category/save', { category: this.category }, function() {
                    UIkit.notify(vm.$trans('Saved.'), '');
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            }

        }

    });

});