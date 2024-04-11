<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VMatchLibModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MatchController extends ResourceController{
    protected $format = 'json';

    public function create()
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $model->insert($data);
        return $this->respondCreated($data);
    }
    public function update($id = null)
    {
        $model = new MatchModel();
        $data = $this->request->getJSON();
        $model->update($id, $data);
        return $this->respond($data);
    }
    // Match par discipline par tournoi selon ordered by prevision date
    public function list_match_by_discipline($id_discipline, $id_tournoi)
    {
        $model = new VMatchLibModel();
        $matchs = $model->where('id_tournoi', $id_tournoi)->where('id_discipline', $id_discipline)->findAll();

        $data = [
            'status' => 1,
            'data' => $matchs
        ];

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
