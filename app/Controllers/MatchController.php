<?php namespace App\Controllers;

use App\Models\MatchModel;
use CodeIgniter\RESTful\ResourceController;

class MatchController extends ResourceController
{
    protected $modelName = 'App\Models\MatchModel';
    protected $format = 'json';

    // Méthode pour récupérer tous les matchs
    public function index()
    {
        $model = new MatchModel();
        $data = $model->findAll();
        return $this->respond($data);
    }

    // Méthode pour récupérer un match par son ID
    public function show($id = null)
    {
        $model = new MatchModel();
        $data = $model->find($id);
        return $this->respond($data);
    }

    // Méthode pour créer un nouveau match
    public function create()
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $model->insert($data);
        return $this->respondCreated($data);
    }

    // Méthode pour mettre à jour un match
    public function update($id = null)
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $model->update($id, $data);
        return $this->respond($data);
    }

    // Méthode pour supprimer un match
    public function delete($id = null)
    {
        $model = new MatchModel();
        $model->delete($id);
        return $this->respondDeleted(['id' => $id]);
    }
}
