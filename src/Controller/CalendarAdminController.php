<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use Pagekit\User\Model\Role;
	use MHDev\Calendar\Model\Category;
	use MHDev\Calendar\Model\Appointment;

	/**
	 * @Access(admin=true)
	 */
	class CalendarAdminController
	{
		public function indexAction()
		{
			return [ 

			'$view' => [
					'title' => 'Calendar',
					'name' => 'calendar:views/admin/index.php'
				]
			];
		}
		
		/**
		 * @Access("system: access settings")
		 */
		public function settingsAction()
		{
			return [
				'$view' => [
					'title' => 'Calendar Settings',
					'name'  => 'calendar:views/admin/settings.php',
				],
				'$data' => [
					'config' => App::module('calendar')->config(),
				],
			];
		}
	}