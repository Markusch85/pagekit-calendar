<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use Pagekit\User\Model\Role;
	use MHDev\Calendar\Model\Category;
	use MHDev\Calendar\Model\Appointment;

	/**
	 * @Access(admin=true)
	 */
	class EventController
	{
		/**
		 * @Access("system: access settings")
		 */
		public function appointmentsAction()
		{
			return [
				'$view' => [
					'title' => 'Calendar Appointments',
					'name'  => 'calendar:views/admin/appointments.php',
				],
				'$data' => [
					'appointments' => Appointment::query()->related(['author'])->get()
				]
			];
		}
		
		/**
		 * @Route("/appointments/load", name="appointments/load")
		 * @Access("calendar: manage own appointments || category: manage all appointments")
		 */
		public function loadAppointmentsAction()
		{
			return [
				'$data' => [
					'appointments' => Appointment::query()->related(['author'])->get()
				]
			];
		}
		
		/**
		 * @Route("/appointments/edit", name="appointments/edit")
		 * @Access("calendar: manage own appointments || category: manage all appointments")
		 * @Request({"id": "int"})
		 */
		public function editAppointmentAction($id = 0)
		{
			if (!$appointment = Appointment::where(compact('id'))->related('author', 'category')->first()) {
                if ($id) {
                    App::abort(404, __('Invalid appointment id'));
                }

                $appointment = Appointment::create([
                    'author_id' => App::user()->id,
                    'start'  => new \DateTime(),
                    'end'  => new \DateTime()
                ]);
            }
			
			$roles = App::db()->createQueryBuilder()
                ->from('@system_role')
                ->where(['id' => Role::ROLE_ADMINISTRATOR])
                ->whereInSet('permissions', ['calendar: manage all appointments', 'calendar: manage own appointments'], false, 'OR')
                ->execute('id')
                ->fetchAll(\PDO::FETCH_COLUMN);

			$authors = App::db()->createQueryBuilder()
                ->from('@system_user')
                ->whereInSet('roles', $roles)
                ->execute('id, username')
                ->fetchAll();
						
			return [
				'$view' => [
					'title' => $id ? 'Edit Appointment' : 'Add Appointment',
					'name'  => 'calendar:views/admin/appointment-edit.php',
				],
				'$data' => [
					'appointment' => $appointment,
					'authors' => $authors,
					'categories' => array_values(Category::findAll())
				]
			];
		}
		
		/**
		 * @Route("/appointments/save", name="appointments/save")
		 * @Request({"appointment": "array", "id": "int"}, csrf=true)
		 */
		public function saveAppointmentAction($data, $id = 0)
		{
			if (!$id || !$appointment = Appointment::find($id)) {
				if ($id) {
					App::abort(404, __('Appointment not found.'));
				}
				$appointment = Appointment::create();
        	}
			
			$appointment = Appointment::create();
			$appointment->save($data);
			return ['message' => 'success', 'appointment' => $appointment];
		}
		
		/**
		 * @Route("/appointments/remove", name="appointments/remove")
		 * @Request({"ids": "array"}, csrf=true)
		 */
		public function removeAppointmentsAction($ids = [])
		{
			foreach ($ids as &$id) {
				if ($id && $appointment = Appointment::find($id)) {
					$appointment->delete();
				} else {
					if ($id) {
						App::abort(404, __('Appointment not found.'));
					}
				}
			}
			return ['message' => 'success', 'appointment' => $appointment];
		}
	}