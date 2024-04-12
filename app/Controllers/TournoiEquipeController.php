<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\VEquipeTournoiTLib;

class TournoiEquipeController extends ResourceController
{
    protected $modelName = 'App\Models\EquipeTournoiJModel';
    protected $format    = 'json';

    public function index()
    {
        $model=new VEquipeTournoiTLib();
        $list=$model->get_teams_of_this_tournament();
        return $this->respond(
            array(
                'error'=>null,
                'data'=>$list,
                "status"=>1
            )
        );
    }

    public function show($id = null)
    {
        
    }

    public function create()
    {
        
    }

    public function update($id = null)
    {
       
    }

    public function delete($id = null)
    {

    }
}
