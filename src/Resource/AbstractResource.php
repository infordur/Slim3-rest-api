<?php
namespace App;

abstract class AbstractResource
{
    
    protected $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }
}