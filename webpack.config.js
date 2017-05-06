module.exports = [
     {
        entry: {
            "link-calendar": "./app/components/link-calendar.vue",
            "calendar": "./app/components/calendar.vue"
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        module: {
            loaders: [
                { test: /\.vue$/, loader: "vue" }
            ]
        }
    },
    {
        entry: {
            "settings": "./app/components/admin/settings.vue",
            "category-edit": "./app/components/admin/category-edit.vue",
            "category-index": "./app/components/admin/category-index.vue",
            "event-edit": "./app/components/admin/event-edit.vue",
            "event-index": "./app/components/admin/event-index.vue"
        },
        output: {
            filename: "./app/bundle/admin/[name].js"
        },
        module: {
            loaders: [
                { test: /\.vue$/, loader: "vue" }
            ]
        }
    }
];