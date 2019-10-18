<?php
namespace App\Action;

use App\Resource\CategoryResource;

final class CategoryAction
{
    private $categoryResource;

    public function __construct(CategoryResource $categoryResource)
    {
        $this->categoryResource = $categoryResource;
    }

    public function getAll($request, $response, $args)
    {
        $tasks = $this->categoryResource->get();
        return $response->withJSON($tasks);
    }

    public function getOne($request, $response, $args)
    {
        $task = $this->categoryResource->get($args['id']);
        return $response->withJSON($task);

    }

    public function search($request, $response, $args)
    {
        $tasks = $this->categoryResource->search($args);
        return $response->withJSON($tasks);
    }


    public function addNew($request, $response, $args)
    {
        $task = $this->categoryResource->post($request->getParsedBody());
        return $response->withJSON($task);
    }
    

    public function updateOne($request, $response, $args)
    {
        $task = $this->categoryResource->put($request->getParsedBody(), $args['id']);
        return $response->withJson($task);
    }

    public function deleteOne($request, $response, $args)
    {
        $task = $this->categoryResource->delete($args['id']);
        return $response->withJSON($task);
    }

}