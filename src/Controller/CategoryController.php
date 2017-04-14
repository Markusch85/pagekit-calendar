<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use Pagekit\User\Model\Role;
	use MHDev\Calendar\Model\Category;
	use MHDev\Calendar\Model\Event;

	/**
	 * @Access(admin=true)
	 */
	class CategoryController
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
		 * @Route("/categories/load", name="categories/load")
		 * @Access("calendar: manage own categories || category: manage all categories")
		 */
		public function loadCategoriesAction()
		{
			return [
				'$data' => [
					'categories' => Category::query()->related(['author'])->get()
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
		 * @Route("/categories/save", name="categories/save")
		 * @Request({"category": "array", "id": "int"}, csrf=true)
		 */
		public function saveCategoryAction($data, $id = 0)
		{
			if (!$id || !$category = Category::find($id)) {
				if ($id) {
					App::abort(404, __('Category not found.'));
				}
				$category = Category::create();
        	}
			
			$category = Category::create();
			$category->save($data);
			return ['message' => 'success', 'category' => $category];
		}
		
		/**
		 * @Route("/categories/remove", name="categories/remove")
		 * @Request({"ids": "array"}, csrf=true)
		 */
		public function removeCategoriesAction($ids = [])
		{
			foreach ($ids as &$id) {
				if ($id && $category = Category::find($id)) {
					$category->delete();
				} else {
					if ($id) {
						App::abort(404, __('Category not found.'));
					}
				}
			}
			return ['message' => 'success', 'category' => $category];
		}
	}