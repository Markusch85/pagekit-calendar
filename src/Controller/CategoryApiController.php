<?php
    namespace MHDev\Calendar\Controller;

    use Pagekit\Application as App;
    use MHDev\Calendar\Model\Category;

    /**
     * @Access("calendar: manage categories")
     * @Route("category", name="category")
     */
    class CategoryApiController
    {
        /**
         * @Route("/", methods="GET")
         * @Request({"filter": "array", "page":"int"})
         */
        public function indexAction($filter = [], $page = 0)
        {
            $query = Category::query();
            $filter = array_merge(array_fill_keys(['status', 'author', 'order', 'limit'], ''), $filter);
            
            extract($filter, EXTR_SKIP);
                        
            if ($author) {
                $query->where(function ($query) use ($author) {
                    $query->orWhere(['author_id' => (int) $author]);
                });
            }
            
            if (!preg_match('/^(name|author)\s(asc|desc)$/i', $order, $order)) {
                $order = [1 => 'name', 2 => 'asc'];
            }
            
            $limit = App::module('calendar')->config('calendar.pagesize');
            $count = $query->count();
            $pages = ceil($count / $limit);
            $page  = max(0, min($pages - 1, $page));
            
            $categories = array_values($query->offset($page * $limit)->related('author')->limit($limit)->orderBy($order[1], $order[2])->get());

            return compact('categories', 'pages', 'count');
        }
        
        /**
         * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
         */
        public function getAction($id)
        {
            return Category::where(compact('id'))->related('author')->first();
        }
        
        /**
         * @Route("/", methods="POST")
         * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
         * @Request({"category": "array", "id": "int"}, csrf=true)
         */
        public function saveAction($data, $id = 0)
        {
            if (!$id || !$category = Category::find($id)) {
                if ($id) {
                    App::abort(404, __('Category not found.'));
                }
                $category = Category::create();
            }
            
            if (!App::user()->hasAccess('calendar: manage categories')) {
                App::abort(400, __('Access denied.'));
            }
            
            $category->save($data);
            return ['message' => 'success', 'category' => $category];
        }
        
         /**
         * @Route(methods="POST")
         * @Request({"ids": "int[]"}, csrf=true)
         */
        public function copyAction($ids = [])
        {
            foreach ($ids as &$id) {
                if(!App::user()->hasAccess('calendar: manage categories')) {
                    continue;
                }
                
                if ($id && $category = Category::find($id)) {
                    $category = clone $category;
                    $category->id = null;
                    $category->category_id = null;
                    $category->save();
                } else {
                    if ($id) {
                        App::abort(404, __('Category not found.'));
                    }
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
                if(!App::user()->hasAccess('calendar: manage categories')) {
                    App::abort(400, __('Access denied.'));
                }
                
                if ($id && $category = Category::find($id)) {
                    $category->delete();
                } else {
                    if ($id) {
                        App::abort(404, __('Category not found.'));
                    }
                }
            }
            return ['message' => 'success'];
        }
    }