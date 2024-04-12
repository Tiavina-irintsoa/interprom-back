<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PouleJModel;

class PouleJController extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        try{
            $model = new PouleJModel();
            $poules = $model->findAll();
            $result = $this->respond($poules);
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        }catch(Exception $ex) {
            return $this->respond(['error' => $ex, 'status' => 0, 'data' => null]);
        }
    }

    public function create()
    {
        $model = new PouleJModel();
        $data = $this->request->getJSON();

        if ($model->insert($data)) {
            return $this->respondCreated($data);
        } else {
            return $this->fail($model->errors());
        }
    }

    public function show($id = null)
    {
        $model = new PouleJModel();
        $poule = $model->find($id);

        if ($poule) {
            return $this->respond($poule);
        } else {
            return $this->failNotFound();
        }
    }

    public function update($id = null)
    {
        $model = new PouleJModel();
        $data = $this->request->getJSON();

        if ($model->update($id, $data)) {
            return $this->respondUpdated($data);
        } else {
            return $this->fail($model->errors());
        }
    }

    public function delete($id = null)
    {
        $model = new PouleJModel();
        $deleted = $model->delete($id);

        if ($deleted) {
            return $this->respondDeleted();
        } else {
            return $this->failNotFound();
        }
    }

    public function get_resultat_poule_choisie($id_poule = null)
    {
        try{
            $result = $this->db->table('match m')
                ->select('*')
                ->join('equipe_tournoi et1', 'et1.id_equipe_tournoi = m.id_equipe_tournoi_1', 'left')
                ->join('equipe_tournoi et2', 'et2.id_equipe_tournoi = m.id_equipe_tournoi_2', 'left')
                ->join('poule p1', 'p1.id_poule = et1.id_poule', 'left')
                ->join('poule p2', 'p2.id_poule = et2.id_poule', 'left')
                ->where('p1.id_poule', $id_poule)
                ->where('p2.id_poule', $id_poule)
                ->get()
                ->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        }catch(Exception $ex) {
            return $this->respond(['error' => $ex, 'status' => 0, 'data' => null]);
        }
    }
}
