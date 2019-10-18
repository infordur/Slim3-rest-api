<?php

namespace App\Resource;

use App\AbstractResource;

/**
 * Class Resource
 * @package App
 */
class TaskResource extends AbstractResource
{
    /**
     * @param string|null $id
     *
     * @return array
     */
    public function get($id = null)
    {
        if ($id === null) {
            $sth = $this->db->prepare("SELECT t.*, c.name as category_name FROM tasks t inner join categories c on t.category_id = c.id");
            $sth->execute();
            $tasks = $sth->fetchAll();

            if(count($tasks)>0) {
                return array(
                    'code' => 200,
                    'data' => $tasks
                );
            } else {
                return array(
                    'code' => 404,
                    'data' => 'No se han encontrado resultados'
                );
            }

        } else {
            $sth = $this->db->prepare("SELECT t.*, c.name as category_name FROM tasks t inner join categories c on t.category_id = c.id WHERE t.id=:id");
            $sth->bindParam("id", $id);
            $sth->execute();
            $task = $sth->fetchObject();

            if($task) {
                return array(
                    'code' => 200,
                    'data' => $task
                );
            }
            return array(
                'code' => 404,
                'message' => 'No se encuentran resultados con el id '.$id
            );
        }

    }


    public function search($args) 
    {
        $sth = $this->db->prepare("SELECT t.*, c.name as category_name FROM categories c LEFT JOIN tasks t ON t.category_id = c.id WHERE UPPER(t.name) LIKE :query ORDER BY t.name;");
        $query = "%".$args['query']."%";
        $sth->bindParam("query", $query);
        $sth->execute();
        $tasks = $sth->fetchAll();
        if(count($tasks)>0) {
            return array(
                'code' => 200,
                'data' => $tasks
            );
        } else {
            return array(
                'code' => 404,
                'message' => 'No se han encontrado resultados'
            );
        }
    }


    public function post($data) 
    {
        $sql = "INSERT INTO tasks (name, description, category_id) VALUES (:name, :description, :category_id)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $data['name']);
        $sth->bindParam("description", $data['description']);
        $sth->bindParam("category_id", $data['category_id']);
        $sth->execute();
        $data['id'] = $this->db->lastInsertId();

        return array(
            'code' => 201,
            'data' => $data
        );
    }


    public function put($data, $id) 
    {
        $sql = "UPDATE tasks SET name=:name, description=:description, category_id=:category_id WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->bindParam("name", $data['name']);
        $sth->bindParam("description", $data['description']);
        $sth->bindParam("category_id", $data['category_id']);
        $sth->execute();
        $countUpdate = $sth->rowCount();

        if($countUpdate == 0) {
            return array(
                'code' => 400,
                'message' => 'Error al actualizar el registro'
            );
        } else {
            return array(
                'code' => 200,
                'message' => 'Registro Actualizado'
            );
        }
        
    }

    public function delete($id = null) 
    {
        if($id !== null) {
                $sql = "DELETE FROM tasks WHERE id=:id";
                $sth = $this->db->prepare($sql);
                $sth->bindParam("id", $id);
                $sth->execute();
                $countDel = $sth->rowCount();
                if($countDel == 0) {
                    return array(
                        'code' => 400,
                        'message' => 'No se ha eliminado el registro'
                    );
                } else {
                    return array(
                        'code' => 200,
                        'message' => 'Registro Eliminado'
                    );
                }
            
        } else {
            return array(
                'code' => 400,
                'message' => 'No se puede eliminar el registro '.$id
            );
        }
        
    }


}