module.exports = [
    {
        entry: {
            "settings": "./app/admin/settings.js"
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        externals: {
            "lodash": "_",
            "jquery": "jQuery",
            "vue": "Vue",
            "uikit": "UIkit",
            "dashboard": "Dashboard",
            "fullcalendar": "fullcalendar"
        },
        module: {
            loaders: [
                {test: /\.json$/, loader: "json"},
                {test: /\.vue$/, loader: "vue"}
            ]
        }
    },
    {
        entry: {
            "fullcalendar": "./node_modules/fullcalendar/dist/fullcalendar.js",
            "locale-all": "./node_modules/fullcalendar/dist/locale-all.js"
        },
        output: {
            filename: "./assets/js/[name].min.js"
        }/*,
        externals: {
            "lodash": "_",
            "jquery": "jQuery",
            "vue": "Vue",
            "uikit": "UIkit",
            "dashboard": "Dashboard",
            "fullcalendar": "fullcalendar"
        },
        module: {
            loaders: [
                {test: /\.json$/, loader: "json"},
                {test: /\.vue$/, loader: "vue"}
            ]
        }*/
    }/*,
    {
        entry: {
            "fullcalendar": "./node_modules/fullcalendar/dist/fullcalendar.css"
        },
        output: {
            filename: "./assets/css/[name].min.js"
        },
        externals: {
            "lodash": "_",
            "jquery": "jQuery",
            "vue": "Vue",
            "uikit": "UIkit",
            "dashboard": "Dashboard",
            "fullcalendar": "fullcalendar"
        },
        module: {
            loaders: [
                {test: /\.json$/, loader: "json"},
                {test: /\.vue$/, loader: "vue"}
            ]
        }
    }*/
];