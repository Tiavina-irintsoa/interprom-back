<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TypeMatchJModel;

class TypeMatchController extends ResourceController
{
    protected $modelName = 'App\Models\TypeMatchJModel';
    protected $format    = 'json';

    public function index()
    {
        $model=new TypeMatchJModel();
        $list=$model->findAll();
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
