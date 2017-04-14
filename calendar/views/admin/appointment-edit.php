<?php $view->script('appointment-edit', 'calendar:app/admin/appointment-edit.js', ['vue', 'editor', 'uikit']) ?>

<form id="appointment" class="uk-form" v-validator="form" @submit.prevent="save | valid">

    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div data-uk-margin>

            <h2 class="uk-margin-remove" v-if="appointment.id">{{ 'Edit Appointment' | trans }}</h2>
            <h2 class="uk-margin-remove" v-else>{{ 'Add Appointment' | trans }}</h2>

        </div>
        <div data-uk-margin>

            <a class="uk-button uk-margin-small-right" :href="$url.route('admin/calendar/appointments')">{{ appointment.id ? 'Close' : 'Cancel' | trans }}</a>
            <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

        </div>
    </div>
	
	<div class="uk-grid pk-grid-large pk-width-sidebar-large uk-form-stacked" data-uk-grid-margin="">
		<div class="pk-width-content uk-row-first">

			<div class="uk-form-row">
				<input class="uk-width-1-1 uk-form-large" name="title" placeholder="Enter title" type="text" v-model="appointment.title">
			</div>

			<div class="uk-form-row">
                <label for="form-category" class="uk-form-label">{{ 'Category' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-category" class="uk-width-1-1" v-model="appointment.category_id">
                        <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                    </select>
                </div>
            </div>
			
			<div class="uk-form-row">
				<label for="form-description" class="uk-form-label">{{ 'Description' | trans }}</label>
				<v-editor id="form-description" :value.sync="appointment.description" :options="{height: 250}"></textarea>
			</div>
			
		</div>
		
		<div class="pk-width-sidebar">
			<div class="uk-form-row">
				<label class="uk-form-label">Start</label>
				<div class="uk-form-controls">
					<input-date :datetime.sync="appointment.start"></input-date>
				</div>
			</div>
			
			<div class="uk-form-row">
				<label class="uk-form-label">End</label>
				<div class="uk-form-controls">
					<input-date :datetime.sync="appointment.end"></input-date>
				</div>
			</div>
			
			<div class="uk-form-row">
				<div class="uk-form-controls">
					<label><input type="checkbox" v-model="appointment.allDay" value="1"> {{ 'Allday event' | trans }}</label>
				</div>
			</div>

			
			<div class="uk-form-row">
                <label for="form-author" class="uk-form-label">{{ 'Author' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-author" class="uk-width-1-1" v-model="appointment.author_id">
                        <option v-for="author in authors" :value="author.id">{{author.username}}</option>
                    </select>
                </div>
            </div>
		</div>
	</div>
	
</form>