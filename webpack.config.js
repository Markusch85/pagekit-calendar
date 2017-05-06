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
var zipFolder = require('zip-folder');

zipFolder('app/bundle', 'calendar.zip', function(err) {
	if(err) {
		console.log('oh no!', err);
	} else {
		console.log('EXCELLENT');
	}
});

zipFolder('src', 'calendar.zip', function(err) {
	if(err) {
		console.log('oh no!', err);
	} else {
		console.log('EXCELLENT');
	}
});