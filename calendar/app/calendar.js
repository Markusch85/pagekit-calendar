$(function(){

    var vm = new Vue({

        el: '#calendar-container',

        data: {
            category: window.$data.events
        },

		ready: function () {
	        this.$watch('', this.load, {immediate: true});
	    },
		
		
        methods: {
			load: function () {
				var locale = $locale.TIMESPAN_FORMATS.localeID;
				/*var locale = $locale.locale.replace('_', '-');
				if (moment.locales().indexOf(locale) === -1) {
					locale = locale.split('-')[0];
				}*/

				var buttons = '';

				if ($config.calendar !== undefined && $config.calendar.buttons !== undefined) {
					buttons += $config.calendar.buttons.today ? 'today ' : '';
					buttons += $config.calendar.buttons.prevnext ? 'prev,next ' : '';
				}

				if ($config.calendar !== undefined && $config.calendar.views !== undefined) {
					buttons += $config.calendar.views.month ? 'month ' : '';
					buttons += $config.calendar.views.week ? 'agendaWeek ' : '';
					buttons += $config.calendar.views.day ? 'agendaDay ' : '';
					buttons += $config.calendar.views.list + ' ';
				}

				var self = this;
				
				// page is now ready, initialize the calendar...	
				$('#calendar').fullCalendar({
					header: {
						left:   'title',
						center: '',
						right:  buttons
					},
					locale: locale,
					timeFormat: $locale.DATETIME_FORMATS.shortTime,
					timezone: 'local',
					events: $data.events,
					eventClick: self.openEvent
				})
			},
			
            openEvent: function(calEvent, jsEvent, view) {
				this.$set('$data.event', $.extend({}, calEvent || {}));
				this.$refs.modal.open();
            }

        }

    });

});