<script>

	module.exports = {
        
        el: '#calendar-container',

        data: {
            title: $config.general.title,
            categories: window.$data.categories,
            category: window.$data.category,
            config: window.$config,
            count: null,
            entries: null
        },
        
        ready: function () {
            this.resource = this.$resource('api/calendar/event{/id}');
            this.$watch('config.filter', this.load, {immediate: true});
        },
          
        indicator: null,
          
        methods: {
            load: function () {
                if ($config.general.loadingindicator) {
                    this.indicator = $('#calendar').loadingIndicator($('#calendar'),{
                        showOnInit: false
                    }).data("loadingIndicator");
                }
                
                var locale = $locale.TIMESPAN_FORMATS.localeID;
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
                
                $('#calendar').fullCalendar({
                    header: {
                        left:   'title',
                        center: '',
                        right:  buttons
                    },
                    locale: locale,
                    timeFormat: $locale.DATETIME_FORMATS.shortTime,
                    timezone: 'local',
                    theme: false,
                    themeButtonIcons: {
                        prev: 'uk-icon-arrow-left',
                        next: 'uk-icon-arrow-right'
                    },
                    defaultView: $config.calendar.views.default,
                    eventClick: self.openEvent,
                    viewRender: self.renderView,
                })
            },
            
            changeCategory: function(selectEvent) {
                $data.category = selectEvent.target.selectedOptions[0].value;
                // These lines are a workaround for rerendering the view
                $('#calendar').fullCalendar('prev');
                $('#calendar').fullCalendar('next');
            },
            
            openEvent: function(calEvent) {
                this.$set('$data.event', $.extend({}, calEvent || {}));
                this.$refs.modal.open();
            },
            
            renderView: function(view) {
                if ($config.general.loadingindicator) {
                    this.indicator.show();
                }
                this.resource.query({ filter: {category: $data.category, start: view.activeRange.start.utc(), end: view.activeRange.end.utc(), readonly: true, order: 'start asc', nolimit:true} }).then(function (res) {

                    var data = res.data;

                    this.$set('$data.entries', data.events);
                    this.$set('count', data.count);
                    
                    $('#calendar').fullCalendar('removeEvents');
                    $('#calendar').fullCalendar('addEventSource', data.events);
                    $('#calendar').fullCalendar('rerenderEvents');
                    $('#calendar').fullCalendar('refetchEvents');
                    if ($config.general.loadingindicator) {
                        this.indicator.hide();    
                    }
                });
            }
        }
    };

	Vue.ready(module.exports);

</script>