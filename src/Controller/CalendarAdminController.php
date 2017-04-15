<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use Pagekit\User\Model\Role;
	use MHDev\Calendar\Model\Category;
	use MHDev\Calendar\Model\Event;

	/**
	 * @Access(admin=true)
	 */
	class CalendarAdminController
	{		
		/**
		 * @Access("system: access settings")
		 */
		public function categoriesAction()
		{
			return [
				'$view' => [
					'title' => 'Calendar Categories',
					'name'  => 'calendar:views/admin/category-index.php',
				]
			];
		}
/**
		 * @Route("/categories/edit", name="categories/edit")
		 * @Access("calendar: manage own categories || category: manage all categories")
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
                ->whereInSet('permissions', ['calendar: manage all categories', 'calendar: manage own categories'], false, 'OR')
                ->execute('id')
                ->fetchAll(\PDO::FETCH_COLUMN);

			$authors = App::db()->createQueryBuilder()
                ->from('@system_user')
                ->whereInSet('roles', $roles)
                ->execute('id, username')
                ->fetchAll();
			
			return [
				'$view' => [
					'title' => $id ? 'Edit Category' : 'Add Category',
					'name'  => 'calendar:views/admin/category-edit.php',
				],
				'$data' => [
					'category' => $category,
					'authors' => $authors
				]
			];
		}
		
		/**
		 * @Access("system: access settings")
		 */
		public function settingsAction()
		{
			return [
				'$view' => [
					'title' => 'Calendar Settings',
					'name'  => 'calendar:views/admin/settings.php',
				],
				'$data' => [
					'config' => App::module('calendar')->config(),
				],
			];
		}
	}