<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use MHDev\Calendar\Model\Event;

	class SiteController
	{
		 /**
		 * @var Module
		 */
		protected $calendar;

		/**
		 * Constructor.
		 */
		public function __construct()
		{
			$this->calendar = App::module('calendar');
		}
	
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
			$events = array_values(Event::query()->where(['category_id' => $id])->get());
			
			foreach ($events as &$event) {
				$event->description = App::content()->applyPlugins($event->description, ['event' => $event, 'markdown' => true]);
			}
			
		  	return [ 
				'$view' => [
					'title' => __('Calendar'),
					'name' => 'calendar:views/calendar.php'
				],
				'$data' => [
					'category' => $id
				],
				'$config' =>  App::module('calendar')->config()
			];
		}
	}