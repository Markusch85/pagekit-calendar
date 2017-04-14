<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use Pagekit\User\Model\Role;
	use MHDev\Calendar\Model\Category;
	use MHDev\Calendar\Model\Event;

	/**
	 * @Access(admin=true)
	 */
	class EventController
	{
		/**
		 * @Access("system: access settings")
		 */
		public function eventsAction()
		{
			return [
				'$view' => [
					'title' => 'Calendar Events',
					'name'  => 'calendar:views/admin/event-index.php',
				]
			];
		}
		
		/**
		 * @Route("/events/load", name="events/load")
		 * @Access("calendar: manage own events || category: manage all events")
		 */
		public function loadEventsAction()
		{
			return [
				'$data' => [
					'events' => Event::query()->related(['author'])->get()
				]
			];
		}
		
		/**
		 * @Route("/events/edit", name="events/edit")
		 * @Access("calendar: manage own events || category: manage all events")
		 * @Request({"id": "int"})
		 */
		public function editEventAction($id = 0)
		{
			if (!$event = Event::where(compact('id'))->related('author', 'category')->first()) {
                if ($id) {
                    App::abort(404, __('Invalid event id'));
                }

                $event = Event::create([
                    'author_id' => App::user()->id,
                    'start'  => new \DateTime(),
                    'end'  => new \DateTime()
                ]);
            }
			
			$roles = App::db()->createQueryBuilder()
                ->from('@system_role')
                ->where(['id' => Role::ROLE_ADMINISTRATOR])
                ->whereInSet('permissions', ['calendar: manage all events', 'calendar: manage own events'], false, 'OR')
                ->execute('id')
                ->fetchAll(\PDO::FETCH_COLUMN);

			$authors = App::db()->createQueryBuilder()
                ->from('@system_user')
                ->whereInSet('roles', $roles)
                ->execute('id, username')
                ->fetchAll();
						
			return [
				'$view' => [
					'title' => $id ? 'Edit Event' : 'Add Event',
					'name'  => 'calendar:views/admin/event-edit.php',
				],
				'$data' => [
					'event' => $event,
					'authors' => $authors,
					'categories' => array_values(Category::findAll())
				]
			];
		}
		
		/**
		 * @Route("/events/save", name="events/save")
		 * @Request({"event": "array", "id": "int"}, csrf=true)
		 */
		public function saveEventAction($data, $id = 0)
		{
			if (!$id || !$event = Event::find($id)) {
				if ($id) {
					App::abort(404, __('Event not found.'));
				}
				$event = Event::create();
        	}
			
			$event = Event::create();
			$event->save($data);
			return ['message' => 'success', 'event' => $event];
		}
		
		/**
		 * @Route("/events/remove", name="events/remove")
		 * @Request({"ids": "array"}, csrf=true)
		 */
		public function removeEventsAction($ids = [])
		{
			foreach ($ids as &$id) {
				if ($id && $event = Event::find($id)) {
					$event->delete();
				} else {
					if ($id) {
						App::abort(404, __('Event not found.'));
					}
				}
			}
			return ['message' => 'success', 'event' => $event];
		}
	}