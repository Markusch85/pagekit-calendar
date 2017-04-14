<?php

	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use MHDev\Calendar\Model\Event;

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
					'events' => array_values(Event::findAll())
				],
				'$config' =>  App::module('calendar')->config()
			];
		}
	}