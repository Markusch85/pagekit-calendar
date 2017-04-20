<?php
    return [
        /*
         * Installation hook.
         */
        'install' => function ($app) {
            $util = $app['db']->getUtility();
            if ($util->tableExists('@calendar_categories') === false) {
                $util->createTable('@calendar_categories', function ($table) {
                    $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                    $table->addColumn('name', 'string', ['length' => 255, 'default' => '']);
                    $table->addColumn('color', 'string', ['length' => 255, 'default' => '#f00']);
                    $table->addColumn('data', 'json_array', ['notnull' => false]);
                    $table->addColumn('author_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                    $table->setPrimaryKey(['id']);
                });
            };
            if ($util->tableExists('@calendar_events') === false) {
                $util->createTable('@calendar_events', function ($table) {
                    $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                    $table->addColumn('title', 'string', ['length' => 255, 'default' => '']);
                    $table->addColumn('description', 'text', ['notnull' => false]);
                    $table->addColumn('start', 'datetime');
                    $table->addColumn('end', 'datetime');
                    $table->addColumn('allDay', 'boolean', ['notnull' => false]);
                    $table->addColumn('data', 'json_array', ['notnull' => false]);
                    $table->addColumn('author_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                    $table->addColumn('category_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                    $table->setPrimaryKey(['id']);
                });
            }
        },
        
        /*
         * Uninstall hook
         */
        'uninstall' => function ($app) {
            $app['config']->remove('calendar');
            
            $util = $app['db']->getUtility();

            if ($util->tableExists('@calendar_events')) {
                $util->dropTable('@calendar_events');
            }
            
            if ($util->tableExists('@calendar_categories')) {
                $util->dropTable('@calendar_categories');
            }
        }
    ];