<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;


class TestDatabase extends Controller
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query('SELECT 1');
        } catch (DatabaseException $e) {
            return $this->response->setBody($e->getMessage());
        }
    }
}