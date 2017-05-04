<?php
    namespace MHDev\Calendar\Controller;

    use Pagekit\Application as App;
    use Pagekit\User\Model\Role;
    use MHDev\Calendar\Model\Category;
    use MHDev\Calendar\Model\Event;

    /**
     * @Access(admin=true)
     */
    class CalendarController
    {        
        const VIEW = '$view';
        const TITLE = 'title';
        const DATA = '$data';
        
        /**
         * @Access("system: access settings")
         */
        public function categoriesAction()
        {
            return [
                self::VIEW => [
                    self::TITLE => __('Calendar Categories'),
                    'name'  => 'calendar:views/admin/category-index.php',
                ]
            ];
        }
        
        /**
         * @Route("/categories/edit", name="categories/edit")
         * @Access("calendar: manage categories")
         * @Request({"id": "int"})
         */
        public function editCategoryAction($id = 0)
        {
            if (!$category = Category::where(compact('id'))->related('author')->first()) {
                if ($id) {
                    App::abort(404, __('Invalid category id'));
                }

                $category = Category::create([
                    'author_id' => App::user()->id,
                    'color' => '#489be0'
                ]);
            }
            
            $roles = App::db()->createQueryBuilder()
                ->from('@system_role')
                ->where(['id' => Role::ROLE_ADMINISTRATOR])
                ->whereInSet('permissions', ['calendar: manage categories'], false, 'OR')
                ->execute('id')
                ->fetchAll(\PDO::FETCH_COLUMN);

            $authors = App::db()->createQueryBuilder()
                ->from('@system_user')
                ->whereInSet('roles', $roles)
                ->execute('id, username')
                ->fetchAll();
            
            return [
                self::VIEW => [
                    self::TITLE => $id ? __('Edit Category') : __('Add Category'),
                    'name'  => 'calendar:views/admin/category-edit.php',
                ],
                self::DATA => [
                    'category' => $category,
                    'authors' => $authors
                ]
            ];
        }
        
        /**
         * @Access("system: access settings")
         */
        public function eventsAction()
        {
            return [
                self::VIEW => [
                    self::TITLE => __('Calendar Events'),
                    'name'  => 'calendar:views/admin/event-index.php',
                ]
            ];
        }
        
        /**
         * @Route("/events/edit", name="events/edit")
         * @Access("calendar: manage events")
         * @Request({"id": "int"})
         */
        public function editEventAction($id = 0)
        {
            if (!$event = Event::where(compact('id'))->related('author', 'category')->first()) {
                if ($id) {
                    App::abort(404, __('Invalid event id'));
                }

                $startDate = new \DateTime();
                $startDate->setTime($startDate->format('H'), 0, 0);
                $endDate = new \DateTime();
                $endDate->setTime($startDate->format('H'), 0, 0);
                $endDate->modify('+1 hour');
                
                $event = Event::create([
                    'author_id' => App::user()->id,
                    'start'  => $startDate,
                    'end'  => $endDate
                ]);
            }
            
            $roles = App::db()->createQueryBuilder()
                ->from('@system_role')
                ->where(['id' => Role::ROLE_ADMINISTRATOR])
                ->whereInSet('permissions', ['calendar: manage events'], false, 'OR')
                ->execute('id')
                ->fetchAll(\PDO::FETCH_COLUMN);

            $authors = App::db()->createQueryBuilder()
                ->from('@system_user')
                ->whereInSet('roles', $roles)
                ->execute('id, username')
                ->fetchAll();
                        
            return [
                self::VIEW => [
                    self::TITLE => $id ? __('Edit Event') : __('Add Event'),
                    'name'  => 'calendar:views/admin/event-edit.php',
                ],
                self::DATA => [
                    'event' => $event,
                    'authors' => $authors,
                    'categories' => array_values(Category::findAll())
                ]
            ];
        }
        
        /**
         * @Access("system: access settings")
         */
        public function settingsAction()
        {
            return [
                self::VIEW => [
                    self::TITLE => __('Calendar Settings'),
                    'name'  => 'calendar:views/admin/settings.php',
                ],
                self::DATA => [
                    'config' => App::module('calendar')->config(),
                ],
            ];
        }
    }