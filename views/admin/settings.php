<?php $view->script('settings', 'calendar:app/admin/settings.js', 'vue') ?>

<div id="settings" class="uk-form uk-form-horizontal" v-cloak>

    <div class="uk-grid pk-grid-large" data-uk-grid-margin>
        <div class="pk-width-sidebar">

            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side pk-nav-large" data-uk-tab="{ connect: '#tab-content' }">
                    <li><a><i class="pk-icon-large-settings uk-margin-right"></i> {{ 'General' | trans }}</a></li>
                    <li><a><i class="pk-icon-large-comment uk-icon-small uk-margin-right"></i> {{ 'Calendar' | trans }}</a></li>
                </ul>

            </div>

        </div>
        <div class="pk-width-content">

            <ul id="tab-content" class="uk-switcher uk-margin">
                <li>

                    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                        <div data-uk-margin>
                            <h2 class="uk-margin-remove">{{ 'General' | trans }}</h2>
                        </div>
                        <div data-uk-margin>
                            <button class="uk-button uk-button-primary" @click.prevent="save">{{ 'Save' | trans }}</button>
                        </div>
                    </div>

                    <div class="uk-form-row">
                        <label class="uk-form-label">{{ 'Website name' | trans }}</label>
                        <div class="uk-form-controls">
                            <p class="uk-form-controls-condensed">
                                <input type="text" v-model="config.general.title" class="uk-form-width-small">
                            </p>
                        </div>
                    </div>
					
					<div class="uk-form-row">
						<span class="uk-form-label">{{ 'Show loading indicator' | trans }}</span>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input type="checkbox" v-model="config.general.loadingindicator" value="">
							</p>
						</div>
					</div>
                </li>
                <li>
                    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                        <div data-uk-margin>
                            <h2 class="uk-margin-remove">{{ 'Calendar' | trans }}</h2>
                        </div>
                        <div data-uk-margin>
                            <button class="uk-button uk-button-primary" @click.prevent="save">{{ 'Save' | trans }}</button>
                        </div>
                    </div>

                    <div class="uk-form-row">
						<span class="uk-form-label">{{ 'Calendar views' | trans }}</span>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<label>
									<input type="checkbox" v-model="config.calendar.views.month" value="">
									{{ 'Month' | trans }}
								</label>
							</p>
							<p class="uk-form-controls-condensed">
								<label>
									<input type="checkbox" v-model="config.calendar.views.week" value="">
									{{ 'Week' | trans }}
								</label>
							</p>
							<p class="uk-form-controls-condensed">
								<label>
									<input type="checkbox" v-model="config.calendar.views.day" value="">
									{{ 'Day' | trans }}
								</label>
							</p>
						</div>
                    </div>
					
					<div class="uk-form-row">
						<span class="uk-form-label">{{ 'List view' | trans }}</span>
						<select id="form-views" v-model="config.calendar.views.list">
							<option value="none">{{ 'None' | trans }}</option>
							<option value="listDay">{{ 'Day' | trans }}</option>
							<option value="listWeek">{{ 'Week' | trans }}</option>
							<option value="listMonth">{{ 'Month' | trans }}</option>
							<option value="listYear">{{ 'Year' | trans }}</option>
						</select>
					</div>
					
					<div class="uk-form-row">
						<span class="uk-form-label">{{ 'Default view' | trans }}</span>
						<select id="form-default-view" v-model="config.calendar.views.default">
							<option value="day">{{ 'Day' | trans }}</option>
							<option value="week">{{ 'Week' | trans }}</option>
							<option value="month">{{ 'Month' | trans }}</option>
							<option value="year">{{ 'Year' | trans }}</option>
							<option value="listDay">{{ 'List: Day' | trans }}</option>
							<option value="listWeek">{{ 'List: Week' | trans }}</option>
							<option value="listMonth">{{ 'List: Month' | trans }}</option>
							<option value="listYear">{{ 'List: Year' | trans }}</option>
						</select>
					</div>
					
					<div class="uk-form-row">
						<span class="uk-form-label">{{ 'Show today button' | trans }}</span>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input type="checkbox" v-model="config.calendar.buttons.today" value="">
							</p>
						</div>
					</div>
					
					<div class="uk-form-row">
						<span class="uk-form-label">{{ 'Show previous/next buttons' | trans }}</span>
						<div class="uk-form-controls uk-form-controls-text">
							<p class="uk-form-controls-condensed">
								<input type="checkbox" v-model="config.calendar.buttons.prevnext" value="">
							</p>
						</div>
					</div>
                </li>
            </ul>

        </div>
    </div>

</div>
