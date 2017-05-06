<?php $view->script('event-edit', 'calendar:app/bundle/admin/event-edit.js', ['vue', 'editor', 'uikit']) ?>

<form id="event" class="uk-form" v-validator="form" @submit.prevent="save | valid">

    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div data-uk-margin>

            <h2 class="uk-margin-remove" v-if="event.id">{{ 'Edit Event' | trans }}</h2>
            <h2 class="uk-margin-remove" v-else>{{ 'Add Event' | trans }}</h2>

        </div>
        <div data-uk-margin>

            <a class="uk-button uk-margin-small-right" :href="$url.route('admin/calendar/events')">{{ event.id ? 'Close' : 'Cancel' | trans }}</a>
            <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

        </div>
    </div>
    
    <div class="uk-grid pk-grid-large pk-width-sidebar-large uk-form-stacked" data-uk-grid-margin="">
        <div class="pk-width-content uk-row-first">

            <div class="uk-form-row">
                <input class="uk-width-1-1 uk-form-large" name="title" :placeholder="'Enter title' | trans" type="text" v-model="event.title" v-validate:required>
                <p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">{{ 'Title cannot be blank.' | trans }}</p>
            </div>

            <div class="uk-form-row">
                <label for="form-category" class="uk-form-label">{{ 'Category' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-category" name="category" class="uk-width-1-1" v-model="event.category_id" v-validate:required>
                        <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                    </select>
                    <p class="uk-form-help-block uk-text-danger" v-show="form.category.invalid">{{ 'Category cannot be blank.' | trans }}</p>
                </div>
            </div>
            
            <div class="uk-form-row">
                <label for="form-description" class="uk-form-label">{{ 'Description' | trans }}</label>
                <v-editor id="form-description" :value.sync="event.description" :options="{markdown: true, height: 250}"></v-editor>
            </div>
            
        </div>
        
        <div class="pk-width-sidebar">
            <div class="uk-form-row">
                <label class="uk-form-label">{{ 'Start' | trans }}</label>
                <div class="uk-form-controls">
                    <input-date :datetime.sync="event.start"></input-date>
                </div>
            </div>
            
            <div class="uk-form-row">
                <div class="uk-form-controls">
                    <label><input type="checkbox" v-model="event.undefinedEnd" value="1"> {{ 'Undefined end' | trans }}</label>
                </div>
            </div>
            
            <div class="uk-form-row" v-if="!event.undefinedEnd">
                <label class="uk-form-label">{{ 'End' | trans }}</label>
                <div class="uk-form-controls">
                    <input-date :datetime.sync="event.end"></input-date>
                </div>
            </div>
            
            <div class="uk-form-row">
                <div class="uk-form-controls">
                    <label><input type="checkbox" v-model="event.allDay" value="1"> {{ 'Allday event' | trans }}</label>
                </div>
            </div>
            
            <div class="uk-form-row">
                <label for="form-author" class="uk-form-label">{{ 'Author' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-author" class="uk-width-1-1" v-model="event.author_id">
                        <option v-for="author in authors" :value="author.id">{{author.username}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
</form>