<?php


// API Group
$app->group('/api', function () use ($app) {
    // Tasks Group
    $app->group('/tasks', function () use ($app) {
        /**
         * GET
         * Get Tasks
         */
        $app->get('', 'App\Action\TaskAction:getAll');

        /**
         * GET
         * Retrieve task with id 
         */
         $app->get('/[{id}]', 'App\Action\TaskAction:getOne');


        /**
         * GET
         * Search for task with given search term in their name
         */
        $app->get('/search/[{query}]', 'App\Action\TaskAction:search');

        /**
         * POST
         * Add a new task
         */
        $app->post('', 'App\Action\TaskAction:addNew');

        /**
         * DELETE
         * DELETE a task with given id
         */
        $app->delete('/[{id}]', 'App\Action\TaskAction:deleteOne');

        /**
         * PUT
         * Update task with given id
         */
        $app->put('/[{id}]', 'App\Action\TaskAction:updateOne');

    });

    //Categories Group
    $app->group('/categories', function () use ($app) {
        /**
         * GET
         * Get Tasks
         */
        $app->get('', 'App\Action\CategoryAction:getAll');

        /**
         * GET
         * Retrieve task with id 
         */
         $app->get('/[{id}]', 'App\Action\CategoryAction:getOne');


        /**
         * GET
         * Search for task with given search term in their name
         */
        $app->get('/search/[{query}]', 'App\Action\CategoryAction:search');

        /**
         * POST
         * Add a new task
         */
        $app->post('', 'App\Action\CategoryAction:addNew');

        /**
         * DELETE
         * DELETE a task with given id
         */
        $app->delete('/[{id}]', 'App\Action\CategoryAction:deleteOne');

        /**
         * PUT
         * Update task with given id
         */
        $app->put('/[{id}]', 'App\Action\CategoryAction:updateOne');

    });
});

