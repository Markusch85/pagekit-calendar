<?php $view->script('category-index', 'calendar:app/admin/category-index.js', 'vue') ?>

<div id="categories" class="uk-form">
	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>
			<h2>{{ '{0} Categories|{1} One Category|]1,Inf[ %count% Categories' | transChoice entries.length {count:entries.length} }}</h2>
		</div>
		<div data-uk-margin>
			<a class="uk-button uk-button-primary" :href="$url.route('admin/calendar/categories/edit')">{{ 'Add Category' | trans }}</a>
		</div>
		
	</div>
	
	<div class="uk-overflow-container">
		<table class="uk-table uk-table-hover uk-table-middle">
			<thead>
				<tr>
					<th class="pk-table-min-width-200">Name</th>
					<th class="pk-table-min-width-200">Color</th>
					<th class="pk-table-width-100">
						<span v-if="!canEditAll">{{ 'Author' | trans }}</span>
						<input-filter :title="$trans('Author')" :value.sync="config.filter.author" :options="authors" v-else></input-filter>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="check-item" v-for="category in entries">
					<td><a :href="$url.route('admin/calendar/categories/edit', { id: category.id })">{{ category.name }}</a></td>
					<td>{{ category.color }}</td>
					<td>
						<a :href="$url.route('admin/user/edit', { id: category.author_id })">{{ category.author.name }}</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>