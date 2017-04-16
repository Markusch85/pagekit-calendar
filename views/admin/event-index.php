<?php $view->script('event-index', 'calendar:app/admin/event-index.js', 'vue') ?>

<div id="events" class="uk-form">
	
	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>
			<h2 class="uk-margin-remove" v-if="!selected.length">{{ '{0} %count% Events|{1} %count% Event|]1,Inf[ %count% Events' | transChoice count {count:count} }}</h2>
			
			<template v-else>
				<h2 class="uk-margin-remove">{{ '{1} %count% Event selected|]1,Inf[ %count% Events selected' | transChoice selected.length {count:selected.length} }}</h2>
				<div class="uk-margin-left">
					<ul class="uk-subnav pk-subnav-icon">
						<li><a class="pk-icon-delete pk-icon-hover" :title="'Delete Events' | trans" data-uk-tooltip="{delay: 500}" @click="remove" v-confirm="'Delete Events?' | trans"></a></li>
					</ul>
				</div>
			 </template>
		</div>
		<div data-uk-margin>
			<a class="uk-button uk-button-primary" :href="$url.route('admin/calendar/events/edit')">{{ 'Add Event' | trans }}</a>
		</div>
	</div>
	
	<div class="uk-overflow-container">
		<table class="uk-table uk-table-hover uk-table-middle">
			<thead>
				<tr>
					<th class="pk-table-width-minimum"><input type="checkbox" v-check-all:selected.literal="input[name=id]" number></th>
					<th class="pk-table-min-width-200">{{ 'Title' | trans }}</th>
					<th class="pk-table-min-width">{{ 'Start' | trans }}</th>
					<th class="pk-table-min-width">{{ 'End' | trans }}</th>
					<th class="pk-table-width-100">
						<span v-if="!canEditAll">{{ 'Author' | trans }}</span>
						<input-filter :title="$trans('Author')" :value.sync="config.filter.author" :options="authors" v-else></input-filter>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="check-item" v-for="event in entries">
					<td><input type="checkbox" name="id" :value="event.id"></td>
					<td><a :href="$url.route('admin/calendar/events/edit', { id: event.id })">{{ event.title }}</a></td>
					<td><time datetime="event.start">{{ event.start | date "short" }}</time></td>
					<td><time datetime="event.end">{{ event.end | date "short" }}</time></td>
					<td>
						<a :href="$url.route('admin/user/edit', { id: event.author_id })">{{ event.author.name }}</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>