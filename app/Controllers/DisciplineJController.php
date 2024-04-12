<?php

namespace App\Controllers;

use App\Models\DisciplineJModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DisciplineJController extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\DisciplineJModel';
    protected $format = 'json';

    // -X GET
    public function index(): ResponseInterface
    {
        try{
            $model = new DisciplineJModel();
            $disciplines = $model->findAll();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $disciplines]);
        }catch(Exception $ex) {
            return $this->respond(['error' => $ex, 'status' => 0, 'data' => null], 403);
        }
    }

    // -X POST
    public function create(): ResponseInterface
    {
        $model = new DisciplineJModel();
        $data = $this->request->getJSON();

        if ($model->insert($data)) {
            return $this->respondCreated(['message' => 'Discipline créé avec succès']);
        } else {
            return $this->failServerError('Erreur lors de la création de l\'utilisateur');
        }
    }

    public function show($id = null): ResponseInterface
    {
        $model = new DisciplineJModel();
        $utilisateur = $model->find($id);

        if ($utilisateur) {
            return $this->respond($utilisateur);
        } else {
            return $this->failNotFound('Discipline non trouvé');
        }
    }

    public function update($id = null): ResponseInterface
    {
        $model = new DisciplineJModel();
        $data = $this->request->getJSON();

        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Discipline mis à jour avec succès']);
        } else {
            return $this->failServerError('Erreur lors de la mise à jour de la discipline');
        }
    }

    // -X DELETE
    public function delete($id = null): ResponseInterface
    {
        $model = new DisciplineJModel();

        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Discipline supprimé avec succès']);
        } else {
            return $this->failServerError('Erreur lors de la suppression de la discipline');
        }
    }
}