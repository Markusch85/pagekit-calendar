<?php $view->script('appointments', 'calendar:app/admin/appointments.js', 'vue') ?>

<div id="appointments" class="uk-form">
	
	<div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
		<div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>
			<h2>{{ '{0} Appointments|{1} One Appointment|]1,Inf[ %count% Appointments' | transChoice entries.length {count:entries.length} }}</h2>
		</div>
		<div data-uk-margin>
			<a class="uk-button uk-button-primary" :href="$url.route('admin/calendar/appointment/edit')">{{ 'Add Appointment' | trans }}</a>
		</div>
	</div>
	
	<div class="uk-overflow-container">
		<table class="uk-table uk-table-hover uk-table-middle">
			<thead>
				<tr>
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