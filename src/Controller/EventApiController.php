<?php
    namespace MHDev\Calendar\Controller;

    use Pagekit\Application as App;
    use MHDev\Calendar\Model\Category;
    use MHDev\Calendar\Model\Event;
    
    /**
     * @Access("calendar: manage events")
     * @Route("event", name="event")
     */
    class EventApiController
    {
        /**
         * @Route("/", methods="GET")
         * @Request({"filter": "array", "page":"int"})
         */
        public function indexAction($filter = [], $page = 0)
        {
            $query = Event::query();
            $filter = array_merge(array_fill_keys(['status', 'author', 'category', 'order', 'limit', 'nolimit'], ''), $filter);
            
            extract($filter, EXTR_SKIP);
            
            if ($category) {
                $query->where(function ($query) use ($category) {
                    $query->orWhere(['category_id' => (int) $category]);
                });
            }
            
            if ($author) {
                $query->where(function ($query) use ($author) {
                    $query->orWhere(['author_id' => (int) $author]);
                });
            }
            
            if (!preg_match('/^(start|end|title|author)\s(asc|desc)$/i', $order, $order)) {
                $order = [1 => 'start', 2 => 'asc'];
            }
            
            $limit = App::module('calendar')->config('calendar.pagesize');
            $count = $query->count();
            if ($filter['nolimit']) {
                $limit = $count;
            }
            $pages = ceil($count / $limit);
            $page  = max(0, min($pages - 1, $page));
            
            $events = array_values($query->offset($page * $limit)->related('author')->limit($limit)->orderBy($order[1], $order[2])->get());

            return compact('events', 'pages', 'count');
        }
        
        /**
         * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
         */
        public function getAction($id)
        {
            return Event::where(compact('id'))->related('author', 'category')->first();
        }
        
        /**
         * @Route("/", methods="POST")
         * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
         * @Request({"event": "array", "id": "int"}, csrf=true)
         */
        public function saveAction($data, $id = 0)
        {
            if (!$id || !$event = Event::find($id)) {
                if ($id) {
                    App::abort(404, __('Event not found.'));
                }
                
                $event = Event::create();
            }
            
            if (!App::user()->hasAccess('calendar: manage events')) {
                App::abort(400, __('Access denied.'));
            }
                
            $event = Event::create();
            $event->save($data);
            return ['message' => 'success', 'event' => $event];
        }
        
         /**
         * @Route(methods="POST")
         * @Request({"ids": "int[]"}, csrf=true)
         */
        public function copyAction($ids = [])
        {
            foreach ($ids as &$id) {
                if(!App::user()->hasAccess('calendar: manage events')) {
                    continue;
                }
                
                if ($id && $event = Event::find($id)) {
                    $event = clone $event;
                    $event->id = null;
                    $event->save();
                }
            }
            return ['message' => 'success'];
        }

        /**
         * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
         * @Request({"id": "int"}, csrf=true)
         */
        public function deleteAction($id)
        {
            foreach ($ids as &$id) {
                if(!App::user()->hasAccess('calendar: manage events')) {
                    App::abort(400, __('Access denied.'));
                }
                
                if ($id && $event = Event::find($id)) {
                    $event->delete();
                } else {
                    if ($id) {
                        App::abort(404, __('Event not found.'));
                    }
                }
            }
            return ['message' => 'success'];
        }
    }