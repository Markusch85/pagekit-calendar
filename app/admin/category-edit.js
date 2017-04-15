$(function(){

    var vm = new Vue({

        el: '#category',

        data: {
            category: window.$data.category,
			authors: window.$data.authors
        },

        methods: {

            save: function() {

                this.$http.post('calendar/categories/save', { category: this.category }, function(data) {
					this.$set('$data.category', data.category);
                    UIkit.notify(vm.$trans('Category saved.'), '');
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            }

        }

    });

});