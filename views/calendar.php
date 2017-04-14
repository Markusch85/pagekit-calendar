<?php $view->script('calendar', 'calendar:app/calendar.js', 'vue') ?>
<?php $view->script('moment', 'calendar:assets/js/moment.min.js', 'jquery') ?>
<?php $view->script('fullCalendar', 'calendar:assets/js/fullcalendar/fullcalendar.min.js') ?>
<?php $view->script('locale-all', 'calendar:assets/js/fullcalendar/locale-all.js') ?>

<?php $view->style('fullCalendar', 'calendar:assets/css/fullcalendar.min.css', ['uikit', 'theme'])?>
<?php $view->style('style', 'calendar:assets/css/style.css', ['uikit'])?>

<div id='calendar-container' class="uk-form">
	<div id='calendar'></div>

	<v-modal v-ref:modal>
		<form class="uk-form uk-form-stacked">

			<div class="uk-modal-header">
				<h2>{{ event.title }}</h2>
			</div>

			<div class="uk-form-row">
				<label>Time</label>
				<div v-if="!event.allDay">
					<span>{{ event.start._i | date "short" }}</span>
					<span> - {{ event.end._i | date "short" }}</span>
				</div>
				<div v-if="event.allDay">
					<span>{{ event.start._i | date }}</span>
					<span v-if="event.end"> - {{ event.end._i | date }}</span>
				</div>
			</div>
						
			<div class="uk-form-row">
				<div class="uk-form-controls uk-form-controls-text">
					<p class="uk-form-controls-condensed">
						<label>
							<input type="checkbox" v-model="event.allDay" disabled>All day
						</label>
					</p>
				</div>
			</div>
			
			<div class="uk-form-row">
				<label for="form-name" class="uk-form-label">{{ 'Description' | trans }}</label>
				<article class="uk-article">
				<div class="uk-margin">{{ event.description | html }}</div>
				</article>
			</div>

			<div class="uk-modal-footer uk-text-right">
				<button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Close' | trans }}</button>
			</div>

		</form>
	</v-modal>
</div>