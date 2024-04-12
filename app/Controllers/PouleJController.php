<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\PouleJModel;

class PouleJController extends ResourceController
{
    public function index()
    {
        try{
            $model = new PouleJModel();
            $poules = $model->findAll();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $poules]);
        }catch(Exception $ex) {
            return $this->respond(['error' => $ex, 'status' => 0, 'data' => null], 403);
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

    public function get_resultat_poule_choisie($id_poule = null): ResponseInterface
    {
        try{
            $db = \Config\Database::connect();
            $builder = $db->table('match m');
            $builder->select('m.*, e1.nom_equipe as nom_equipe_1, e2.nom_equipe as nom_equipe_2');
            $builder->join('equipe_tournoi et1', 'et1.id_equipe_tournoi = m.id_equipe_tournoi_1', 'left');
            $builder->join('equipe_tournoi et2', 'et2.id_equipe_tournoi = m.id_equipe_tournoi_2', 'left');
            $builder->join('poule p1', 'p1.id_poule = et1.id_poule', 'left');
            $builder->join('poule p2', 'p2.id_poule = et2.id_poule', 'left');
            $builder->join('equipe e1', 'e1.id_equipe = et1.id_equipe', 'left');
            $builder->join('equipe e2', 'e2.id_equipe = et2.id_equipe', 'left');
            $builder->where('p1.id_poule', $id_poule);
            $builder->where('p2.id_poule', $id_poule);
            $query = $builder->get();
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        }catch(Exception $ex) {
            return $this->respond(['error' => $ex, 'status' => 0, 'data' => null], 403);
        }
    }

    public function get_classement_par_poule_choisi($id_poule = null): ResponseInterface
    {
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('v_all_resultat_par_equipe_tournoi vr');
            $builder->select('vr.*, e.*');
            $builder->join('equipe_tournoi et', 'et.id_equipe_tournoi = vr.id_equipe_tournoi');
            $builder->join('equipe e', 'e.id_equipe = et.id_equipe');
            $builder->join('poule p', 'p.id_poule = et.id_poule');
            $builder->where('et.id_poule', $id_poule);
            $builder->where('et.id_poule', $id_poule);
            $builder->orderBy('vr.points', 'DESC');
            $query = $builder->get();
            $result = $query->getResult();
            return $this->respond(['error' => null, 'status' => 1, 'data' => $result]);
        } catch (Exception $ex) {
            return $this->respond(['error' => $ex, 'status' => 0, 'data' => null], 403);
        }
    }  
}


