<?php

namespace App\Resource;

use App\AbstractResource;

/**
 * Class Resource
 * @package App
 */
class CategoryResource extends AbstractResource
{
    /**
     * @param string|null $id
     *
     * @return array
     */
    public function get($id = null)
    {
        if ($id === null) {
            $sth = $this->db->prepare("SELECT * FROM categories");
            $sth->execute();
            $categories = $sth->fetchAll();

            if(count($categories)>0) {
                return array(
                    'code' => 200,
                    'data' => $categories
                );
            } else {
                return array(
                    'code' => 404,
                    'data' => 'No se han encontrado resultados'
                );
            }

        } else {
            $sth = $this->db->prepare("SELECT * FROM categories WHERE id=:id");
            $sth->bindParam("id", $id);
            $sth->execute();
            $category = $sth->fetchObject();

            if($category) {
                return array(
                    'code' => 200,
                    'data' => $category
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
        $sth = $this->db->prepare("SELECT * FROM categories WHERE UPPER(name) LIKE :query ORDER BY name");
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
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $data['name']);
        $sth->execute();
        $data['id'] = $this->db->lastInsertId();

        return array(
            'code' => 201,
            'data' => $data
        );
    }


    public function put($data, $id) 
    {
        $sql = "UPDATE categories SET name=:name WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->bindParam("name", $data['name']);
        $sth->execute();
        $countUpdate = $sth->rowCount();

        if($countUpdate == 0) {
            return array(
                'code' => 400,
                'message' => 'No se puedo actualizar el registro'
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
                $sql = "DELETE FROM categories WHERE id=:id";
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