<?php
namespace App\Action;

use App\Resource\TaskResource;

final class TaskAction
{
    private $taskResource;

    public function __construct(TaskResource $taskResource)
    {
        $this->taskResource = $taskResource;
    }

    public function getAll($request, $response, $args)
    {
        $tasks = $this->taskResource->get();
        return $response->withJSON($tasks);
    }

    public function getOne($request, $response, $args)
    {
        $task = $this->taskResource->get($args['id']);
        return $response->withJSON($task);

    }

    public function search($request, $response, $args)
    {
        $tasks = $this->taskResource->search($args);
        return $response->withJSON($tasks);
    }


    public function addNew($request, $response, $args)
    {
        $task = $this->taskResource->post($request->getParsedBody());
        return $response->withJSON($task);
    }
    

    public function updateOne($request, $response, $args)
    {
        $task = $this->taskResource->put($request->getParsedBody(), $args['id']);
        return $response->withJson($task);
    }

    public function deleteOne($request, $response, $args)
    {
        $task = $this->taskResource->delete($args['id']);
        return $response->withJSON($task);
    }

}