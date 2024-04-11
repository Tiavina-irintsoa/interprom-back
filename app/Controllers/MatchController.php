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



    public function update_score(){
        $model = new MatchModel();
        $data=$this->request->getJSON();
        $match = $model->find($data->idmatch);
        if($data->points<0 || is_numeric($data->points)==false){
            return $this->respond(array('error'=>'Points invalides','data'=>null,'status'=>0));
        }
        if (!$match) {
            return $this->respond(array('error'=>'Ce match n\'existe pas','data'=>null,'status'=>0));
        }
        else{
            if($match['fin_reel']!=''){
                return $this->respond(array('error'=>'Ce match est déjà terminé','data'=>null,'status'=>0));
            }
            if($match['debut_reel']==''){
                return $this->respond(array('error'=>'Ce match n\' a pas encore commencé','data'=>null,'status'=>0));
            }
        }
        
        
        if($data->equipe!=1 && $data->equipe!=2){
            return $this->respond(array('error'=>'L\'equipe doit être 1 ou 2','data'=>null,'status'=>0));
        }
        $match=$model->updateScore($data,$match);
        return $this->respond(array('error'=>null,'data'=>$match,'status'=>1));
    }
}
