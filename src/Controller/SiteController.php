<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use MHDev\Calendar\Model\Event;

	class SiteController
	{
		/**
		 * @Route("/")
		 */
		public function indexAction()
		{
		  	return [ 

				'$view' => [
					'title' => __('Calendar'),
					'name' => 'calendar:views/calendar.php'
				],
				'$data' => [
					'events' => array_values(Event::findAll())
				],
				'$config' =>  App::module('calendar')->config()
			];
		}
		
		/**
		 * @Route("/category", name="category")
		 * @Request({"id": "int"})
		 */
		public function categoryAction($id)
		{
		  	return [ 

				'$view' => [
					'title' => __('Calendar'),
					'name' => 'calendar:views/calendar.php'
				],
				'$data' => [
					'events' => array_values(Event::query()->where(['category_id' => $id])->get())
				],
				'$config' =>  App::module('calendar')->config()
			];
		}
	}