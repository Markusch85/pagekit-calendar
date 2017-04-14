<?php

	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use MHDev\Calendar\Model\Appointment;

	class CalendarController
	{
		/**
		 * @Route("/")
		 */
		public function siteAction()
		{
		  	return [ 

				'$view' => [
					'title' => 'Calendar',
					'name' => 'calendar:views/calendar.php'
				],
				'$data' => [
					'events' => array_values(Appointment::findAll())
				],
				'$config' =>  App::module('calendar')->config()
			];
		}
	}