<?php
	namespace MHDev\Calendar\Controller;

	use Pagekit\Application as App;
	use Pagekit\User\Model\Role;
	use MHDev\Calendar\Model\Category;
	use MHDev\Calendar\Model\Event;

	class CategoryApiController
	{
		/**
		 * @Route("/categories/load", name="categories/load")
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