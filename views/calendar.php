<?php $view->script('calendar', 'calendar:app/calendar.js', ['vue', 'editor', 'uikit']) ?>
<?php $view->script('moment', 'calendar:assets/js/moment.min.js', 'jquery') ?>
<?php $view->script('fullCalendar', 'calendar:assets/js/fullcalendar/fullcalendar.min.js') ?>
<?php $view->script('locale-all', 'calendar:assets/js/fullcalendar/locale-all.js') ?>
<?php $view->script('loading-indicator', 'calendar:assets/js/jquery.loading-indicator.min.js') ?>

<?php $view->style('fullCalendar', 'calendar:assets/css/fullcalendar.min.css', ['uikit', 'theme'])?>
<?php $view->style('style', 'calendar:assets/css/style.css', ['uikit'])?>
<?php $view->style('loading-indicator-style', 'calendar:assets/css/jquery.loading-indicator.css')?>

<div id='calendar-container' class="uk-form">
	<h1>{{ title }}</h1>
	<div v-if="categories.length > 2">
		<label class="uk-form-label">{{ 'Category' | trans }}</label>
		<div class="uk-form-controls">
			<select name="category" v-model="category" v-on:change="changeCategory">
				<option v-for="category in categories" :value="category.id">{{category.name}}</option>
			</select>
		</div>
	</div>
	<div id='calendar'></div>

	<v-modal v-ref:modal>
		<form class="uk-form uk-form-stacked">

			<div class="uk-modal-header">
				<h2>{{ event.title }}</h2>
			</div>

			<div class="uk-form-row">
				<label>{{ 'Start' | trans }}</label>
				<div>
					<span v-if="!event.allDay">{{ event.start._i | date "short" }}</span>
					<span v-else>{{ event.start._i | date }}</span>
				</div>
			</div>
			
			<div class="uk-form-row" v-if="!event.undefinedEnd">
				<label>{{ 'End' | trans }}</label>
				<div>
					<span v-if="!event.allDay">{{ event.end._i | date "short" }}</span>
					<span v-else>{{ event.end._i | date }}</span>
				</div>
			</div>
			
			<div class="uk-form-row">
				<div v-html="event.description"></div>
			</div>

			<div class="uk-modal-footer uk-text-right">
				<button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Close' | trans }}</button>
			</div>

		</form>
	</v-modal>
</div>