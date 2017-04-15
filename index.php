<?php

	use Pagekit\Application;

	// packages/mhdev/calendar/index.php

	return [

		'name' => 'calendar',

		'type' => 'extension',

		// array of namespaces to autoload from given folders
		'autoload' => [
			'MHDev\\Calendar\\' => 'src'
		],
		

		// array of routes
		'routes' => [

			// identifier to reference the route from your code
			'/calendar' => [
				'name' => '@calendar',
				'controller' => [
					'MHDev\\Calendar\\Controller\\CalendarAdminController',
					'MHDev\\Calendar\\Controller\\EventController',
					'MHDev\\Calendar\\Controller\\CategoryController',
					'MHDev\\Calendar\\Controller\\SiteController'
				]
			]
		],
		
		'menu' => [

			'calendar' => [
				'label'  => 'Calendar',
				'icon'   => 'app/system/assets/images/placeholder-icon.svg',
				'url'    => '@calendar/categories',
				'active' => '@calendar/categories/*',
			],

			'calendar: categories' => [
				'parent' => 'calendar',
				'label'  => 'Categories',
				'icon'   => 'app/system/assets/images/placeholder-icon.svg',
				'url'    => '@calendar/categories',
				'active' => '@calendar/categories*',
				'access' => 'calendar: manage own categories'
			],
			
			'calendar: events' => [
				'parent' => 'calendar',
				'label'  => 'Events',
				'icon'   => 'app/system/assets/images/placeholder-icon.svg',
				'url'    => '@calendar/events',
				'active' => '@calendar/events*',
				'access' => 'calendar: manage own events'
			],
			
			'calendar: settings' => [
				'parent' => 'calendar',
				'label'  => 'Settings',
				'url'    => '@calendar/settings',
				'active' => '@calendar/settings*',
				'access' => 'system: access settings',
			],
		],
		
		'permissions' => [

			'calendar: manage settings' => [
				'title' => 'Manage settings',
			],
			'calendar: manage own categories' => [
				'title' => 'Manage own categories',
			],
			'calendar: manage all categories' => [
				'title' => 'Manage all categories',
			],
			'calendar: manage own events' => [
				'title' => 'Manage own events',
			],
			'calendar: manage all events' => [
				'title' => 'Manage all events',
			],
		],
		
		'settings' => '@calendar/settings',

		'config' => [
			'general' => [
				'title' => 'Calendar'
			],
			'calendar' => [
				'views' => [
					'month' => true,
					'week' => true,
					'day' => true,
					'list' => 'none'
				],
				'buttons' => [
					'today' => true,
					'prevnext' => true
				]
			]
		],
		
		'events' => [
			'view.scripts' => function ($event, $scripts) {
				$scripts->register('calendar-link', 'calendar:app/bundle/link-calendar.js', '~panel-link');
			},

		]
	];