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
			'@calendar' => [
				'path' => '/calendar',
				'controller' => [
					'MHDev\\Calendar\\Controller\\CalendarController',
					'MHDev\\Calendar\\Controller\\CalendarAdminController',
					'MHDev\\Calendar\\Controller\\EventController',
					'MHDev\\Calendar\\Controller\\CategoryController'
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
			
			'calendar: appointments' => [
				'parent' => 'calendar',
				'label'  => 'Appointments',
				'icon'   => 'app/system/assets/images/placeholder-icon.svg',
				'url'    => '@calendar/appointments',
				'active' => '@calendar/appointments*',
				'access' => 'calendar: manage own appointments'
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
			'calendar: manage own appointments' => [
				'title' => 'Manage own appointments',
			],
			'calendar: manage all appointments' => [
				'title' => 'Manage all appointments',
			],
		],
		
		'settings' => '@calendar/settings',

		'config' => [
			'general' => [
				'title'              => 'Calendar'
			]
		]
	];