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
			$categories = array_values(Event::query()->where(['category_id' => $id])->get());
			
			foreach ($categories as &$category) {
				$category->description = App::content()->applyPlugins($category->description, ['category' => $category, 'markdown' => true]);
			}
			
			
		  	return [ 
				'$view' => [
					'title' => __('Calendar'),
					'name' => 'calendar:views/calendar.php'
				],
				'$data' => [
					'events' => $categories
				],
				'$config' =>  App::module('calendar')->config()
			];
		}
	}