<template>

    <div class="uk-form-row">
        <label for="form-link-calendar" class="uk-form-label">{{ 'View' | trans }}</label>
        <div class="uk-form-controls">
            <select id="form-link-calendar" class="uk-width-1-1" v-model="link">
                <option value="@calendar">{{ 'Calendar' | trans }}</option>
                <optgroup :label="'Categories' | trans">
                    <option v-for="p in categories" :value="p | link">{{ p.name }}</option>
                </optgroup>
            </select>
        </div>
    </div>

</template>

<script>

    module.exports = {

        link: {
            label: 'Calendar'
        },

        props: ['link'],

        data: function () {
            return {
                categories: []
            }
        },

        created: function () {
            this.$http.get('api/calendar/categories/load').then(function (res) {
                this.$set('categories', res.data.$data.categories);
            });
        },

        ready: function() {
            this.link = '@calendar';
        },

        filters: {
            link: function (category) {
                return '@calendar/category?id='+category.id;
            }
        }

    };

    window.Links.components['link-calendar'] = module.exports;

</script>
