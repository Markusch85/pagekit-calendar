<?php $view->script('category-index', 'calendar:app/bundle/admin/category-index.js', 'vue') ?>

<div id="categories" class="uk-form">
    <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>
            <h2 class="uk-margin-remove" v-if="!selected.length">{{ '{0} %count% Categories|{1} %count% Category|]1,Inf[ %count% Categories' | transChoice count {count:count} }}</h2>
            
            <template v-else>
                <h2 class="uk-margin-remove">{{ '{1} %count% Category selected|]1,Inf[ %count% Categories selected' | transChoice selected.length {count:selected.length} }}</h2>
                <div class="uk-margin-left">
                    <ul class="uk-subnav pk-subnav-icon">
                        <li><a class="pk-icon-copy pk-icon-hover" :title="'Copy Categories' | trans" data-uk-tooltip="{delay: 500}" @click="copy" v-confirm="'Copy Categories?' | trans"></a></li>
                        <li><a class="pk-icon-delete pk-icon-hover" :title="'Delete Categories' | trans" data-uk-tooltip="{delay: 500}" @click="remove" v-confirm="'Delete Categories?' | trans"></a></li>
                    </ul>
                </div>
             </template>
        </div>
        <div data-uk-margin>
            <a class="uk-button uk-button-primary" :href="$url.route('admin/calendar/categories/edit')">{{ 'Add Category' | trans }}</a>
        </div>
        
    </div>
    
    <div class="uk-overflow-container">
        <table class="uk-table uk-table-hover uk-table-middle">
            <thead>
                <tr>
                    <th class="pk-table-width-minimum"><input type="checkbox" v-check-all:selected.literal="input[name=id]" number></th>
                    <th class="pk-table-min-width-200" v-order:name="config.filter.order">{{ 'Name' | trans }}</th>
                    <th class="pk-table-min-width-200">{{ 'Color' | trans }}</th>
                    <th class="pk-table-width-100">
                        <span v-if="!canEditAll">{{ 'Author' | trans }}</span>
                        <input-filter :title="$trans('Author')" :value.sync="config.filter.author" :options="authors" v-else></input-filter>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="check-item" v-for="category in entries">
                    <td><input type="checkbox" name="id" :value="category.id"></td>
                    <td><a :href="$url.route('admin/calendar/categories/edit', { id: category.id })">{{ category.name }}</a></td>
                    <td>{{ category.color }}</td>
                    <td>
                        <a :href="$url.route('admin/user/edit', { id: category.author_id })">{{ category.author.name }}</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1 || page > 0"></v-pagination>
</div>