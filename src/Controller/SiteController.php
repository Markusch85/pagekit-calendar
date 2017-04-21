<?php
    namespace MHDev\Calendar\Controller;

    use Pagekit\Application as App;
    use MHDev\Calendar\Model\Event;
    use MHDev\Calendar\Model\Category;

    class SiteController
    {
		const CALENDAR = 'calendar';
		
         /**
         * @var Module
         */
        protected $calendar;

        /**
         * Constructor.
         */
        public function __construct()
        {
            $this->calendar = App::module(self::CALENDAR);
        }
    
        /**
         * @Route("/")
         */
        public function indexAction()
        {
            $allCategory = new Category();
            $allCategory->id = '';
            $allCategory->name = __('All');
            
            $categories = array_values(Category::findAll());
            array_unshift($categories, $allCategory);
            
              return [ 
                '$view' => [
                    'title' => __('Calendar'),
                    'name' => 'calendar:views/calendar.php'
                ],
                '$data' => [
                    'category' => '',
                    'categories' => $categories
                ],
                '$config' =>  App::module(self::CALENDAR)->config()
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
            
            $allCategory = new Category();
            $allCategory->id = '';
            $allCategory->name = __('All');
            
            $categories = array_values(Category::findAll());
            array_unshift($categories, $allCategory);
            
              return [ 
                '$view' => [
                    'title' => __('Calendar'),
                    'name' => 'calendar:views/calendar.php'
                ],
                '$data' => [
                    'category' => $id,
                    'categories' => $categories
                ],
                '$config' =>  App::module(self::CALENDAR)->config(),
            ];
        }
    }