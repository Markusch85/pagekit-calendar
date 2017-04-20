<?php $view->script('category-edit', 'calendar:app/admin/category-edit.js', ['vue', 'editor', 'uikit']) ?>

<form id="category" class="uk-form" v-validator="form" @submit.prevent="save | valid">

    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div data-uk-margin>

            <h2 class="uk-margin-remove" v-if="category.id">{{ 'Edit Category' | trans }}</h2>
            <h2 class="uk-margin-remove" v-else>{{ 'Add Category' | trans }}</h2>

        </div>
        <div data-uk-margin>

            <a class="uk-button uk-margin-small-right" :href="$url.route('admin/calendar/categories')">{{ category.id ? 'Close' : 'Cancel' | trans }}</a>
            <button class="uk-button uk-button-primary" type="submit">{{ 'Save' | trans }}</button>

        </div>
    </div>
    
    <div class="uk-grid pk-grid-large pk-width-sidebar-large uk-form-stacked" data-uk-grid-margin="">
        <div class="pk-width-content uk-row-first">

            <div class="uk-form-row">
                <input class="uk-width-1-1 uk-form-large" name="title" :placeholder="'Enter name' | trans" type="text" v-model="category.name" v-validate:required>
                <p class="uk-form-help-block uk-text-danger" v-show="form.title.invalid">{{ 'Name cannot be blank.' | trans }}</p>
            </div>

            
        </div>
        
        <div class="pk-width-sidebar">
            <div class="uk-form-row">
                <label for="form-color" class="uk-form-label">{{ Color | trans }}</label>
                <div class="uk-form-controls">
                    <input id="form-color" class="uk-width-1-1" type="color" v-model="category.color">
                </div>
            </div>
            
            <div class="uk-form-row">
                <label for="form-author" class="uk-form-label">{{ 'Author' | trans }}</label>
                <div class="uk-form-controls">
                    <select id="form-author" class="uk-width-1-1" v-model="category.author_id">
                        <option v-for="author in authors" :value="author.id">{{author.username}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
</form>