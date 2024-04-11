<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PouleModel;

class PouleController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new PouleModel();
        $poules = $model->findAll();

        return $this->respond($poules);
    }

    public function create()
    {
        $model = new PouleModel();
        $data = $this->request->getJSON();

        if ($model->insert($data)) {
            return $this->respondCreated($data);
        } else {
            return $this->fail($model->errors());
        }
    }

    public function show($id = null)
    {
        $model = new PouleModel();
        $poule = $model->find($id);

        if ($poule) {
            return $this->respond($poule);
        } else {
            return $this->failNotFound();
        }
    }

    public function update($id = null)
    {
        $model = new PouleModel();
        $data = $this->request->getJSON();

        if ($model->update($id, $data)) {
            return $this->respondUpdated($data);
        } else {
            return $this->fail($model->errors());
        }
    }

    public function delete($id = null)
    {
        $model = new PouleModel();
        $deleted = $model->delete($id);

        if ($deleted) {
            return $this->respondDeleted();
        } else {
            return $this->failNotFound();
        }
    }
}
