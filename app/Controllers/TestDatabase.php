<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;


class TestDatabase extends Controller
{
    public function index()
    {
        try {
            
            $db = \Config\Database::connect();
            $query = $db->query('SELECT 1');
            return $this->response->setBody(json_encode($query->getRow()));
        } catch (Exception $e) {
            return $this->response->setBody($e->getMessage());
        }
        
    }
}