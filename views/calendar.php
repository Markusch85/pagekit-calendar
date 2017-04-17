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
	<div id='calendar'></div>

	<v-modal v-ref:modal>
		<form class="uk-form uk-form-stacked">

			<div class="uk-modal-header">
				<h2>{{ event.title }}</h2>
			</div>

			<div class="uk-form-row">
				<!--<span>On 8.10.2012, 12:00 to 16:00</span>-->
				<span>On 8.10.2012, 12:00</span>
				
				<!--<span>From 8.10.2012, 12:00 to 9.10.2012, 20:00</span>-->
			</div>
			
			<div class="uk-form-row">
				<label>{{ 'Time' | trans }}</label>
				<div v-if="!event.allDay">
					<span>{{ event.start._i | date "short" }}</span>
					<span v-if="event.end"> - {{ event.end._i | date "short" }}</span>
				</div>
				<div v-if="event.allDay">
					<span>{{ event.start._i | date }}</span>
					<span v-if="!event.undefinedEnd"> - {{ event.end._i | date }}</span>
				</div>
			</div>
				
			<div class="uk-form-row">
				<div class="uk-form-controls uk-form-controls-text">
					<p class="uk-form-controls-condensed">
						<label>
							<input type="checkbox" v-model="event.allDay" disabled>{{ 'Allday event' | trans }}
						</label>
					</p>
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