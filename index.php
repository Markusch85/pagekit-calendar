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
					'MHDev\\Calendar\\Controller\\CalendarController',
					'MHDev\\Calendar\\Controller\\SiteController'
				]
			],
			
			// identifier to reference the route from your code
			'/api/calendar' => [
				'name' => '@calendar/api',
				'controller' => [
					'MHDev\\Calendar\\Controller\\CalendarApiController',
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
			'calendar: manage categories' => [
				'title' => 'Manage categories',
			],
			'calendar: manage events' => [
				'title' => 'Manage events',
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