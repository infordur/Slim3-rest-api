<?php


// API group
$app->group('/api', function () use ($app) {
    // Tasks group
    $app->group('/tasks', function () use ($app) {
        /**
         * GET
         * Get Tasks
         */
        $app->get('', function ($request, $response, $args) {
            $sth = $this->db->prepare("SELECT t.*, c.name as category_name FROM tasks t inner join category c on t.category_id = c.id");
            $sth->execute();
            $tasks = $sth->fetchAll();
            return $this->response->withJson($tasks);
        });

        /**
         * GET
         * Retrieve task with id 
         */
        $app->get('/[{id}]', function ($request, $response, $args) {
            $sth = $this->db->prepare("SELECT t.*, c.name as category_name FROM category c LEFT JOIN tasks t ON t.category_id = c.id WHERE t.id =:id");
            $sth->bindParam("id", $args['id']);
            $sth->execute();
            $tasks = $sth->fetchObject();
            return $this->response->withJson($tasks);
        });


        /**
         * GET
         * Search for task with given search term in their name
         */
        $app->get('/search/[{query}]', function ($request, $response, $args) {
            $sth = $this->db->prepare("SELECT t.*, c.name as category_name FROM category c LEFT JOIN tasks t ON t.category_id = c.id WHERE UPPER(t.name) LIKE :query ORDER BY t.name;");
            $query = "%".$args['query']."%";
            $sth->bindParam("query", $query);
            $sth->execute();
            $tasks = $sth->fetchAll();
            return $this->response->withJson($tasks);
        });

        /**
         * POST
         * Add a new task
         */
        $app->post('', function ($request, $response) {

            $input = $request->getParsedBody();
            $sql = "INSERT INTO tasks (name, description, category_id) VALUES (:name, :description, :category_id)";
            $sth = $this->db->prepare($sql);
            $sth->bindParam("name", $input['name']);
            $sth->bindParam("description", $input['description']);
            $sth->bindParam("category_id", $input['category_id']);
            $sth->execute();
            $input['id'] = $this->db->lastInsertId();
            return $this->response->withJson($input);
        });

        /**
         * DELETE
         * DELETE a task with given id
         */
        $app->delete('/[{id}]', function ($request, $response, $args) {
            $sth = $this->db->prepare("DELETE FROM tasks WHERE id=:id");
            $sth->bindParam("id", $args['id']);
            $sth->execute();
            $todos = $sth->fetchAll();
            return $this->response->withJson($todos);
        });

        /**
         * PUT
         * Update task with given id
         */
        $app->put('/[{id}]', function ($request, $response, $args) {
            $input = $request->getParsedBody();
            $sql = "UPDATE tasks SET name=:name, description=:description, category_id=:category_id WHERE id=:id";
            $sth = $this->db->prepare($sql);
            $sth->bindParam("id", $args['id']);
            $sth->bindParam("name", $input['name']);
            $sth->bindParam("description", $input['description']);
            $sth->bindParam("category_id", $input['category_id']);
            $sth->execute();
            $input['id'] = $args['id'];
            return $this->response->withJson($input);
        });

    });

    //Categories
    // TODO
});

