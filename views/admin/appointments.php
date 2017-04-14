<?php $view->script('appointments', 'calendar:app/admin/appointments.js', 'vue') ?>

<div id="appointments" class="uk-form">
	
	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>
			<h2 class="uk-margin-remove" v-if="!selected.length">{{ '{0} %count% Appointments|{1} %count% Appointment|]1,Inf[ %count% Appointments' | transChoice count {count:count} }}</h2>
			
			<template v-else>
				<h2 class="uk-margin-remove">{{ '{1} %count% Appointment selected|]1,Inf[ %count% Appointments selected' | transChoice selected.length {count:selected.length} }}</h2>
				<div class="uk-margin-left">
					<ul class="uk-subnav pk-subnav-icon">
						<!--<li><a class="pk-icon-copy pk-icon-hover" title="Copy" data-uk-tooltip="{delay: 500}" @click="copy"></a></li>-->
						<li><a class="pk-icon-delete pk-icon-hover" title="Delete" data-uk-tooltip="{delay: 500}" @click="remove" v-confirm="'Delete Appointments?'"></a></li>
					</ul>
				</div>
			 </template>
		</div>
		<div data-uk-margin>
			<a class="uk-button uk-button-primary" :href="$url.route('admin/calendar/appointment/edit')">{{ 'Add Appointment' | trans }}</a>
		</div>
	</div>
	
	<div class="uk-overflow-container">
		<table class="uk-table uk-table-hover uk-table-middle">
			<thead>
				<tr>
					<th class="pk-table-width-minimum"><input type="checkbox" v-check-all:selected.literal="input[name=id]" number></th>
					<th class="pk-table-min-width-200">Name</th>
					<th class="pk-table-min-width">Start</th>
					<th class="pk-table-min-width">End</th>
					<th class="pk-table-width-100">
						<span v-if="!canEditAll">{{ 'Author' | trans }}</span>
						<input-filter :title="$trans('Author')" :value.sync="config.filter.author" :options="authors" v-else></input-filter>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="check-item" v-for="appointment in entries">
					<td><input type="checkbox" name="id" :value="appointment.id"></td>
					<td><a :href="$url.route('admin/calendar/appointment/edit', { id: appointment.id })">{{ appointment.title }}</a></td>
					<td><time datetime="appointment.start">{{ appointment.start | date "short" }}</time></td>
					<td><time datetime="appointment.end">{{ appointment.end | date "short" }}</time></td>
					<td>
						<a :href="$url.route('admin/user/edit', { id: appointment.author_id })">{{ appointment.author.name }}</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>