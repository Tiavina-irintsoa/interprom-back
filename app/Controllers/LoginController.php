<?php

namespace App\Controllers;

use App\Models\UtilisateurJModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class LoginController extends ResourceController
{
    protected $modelName = 'App\Models\UtilisateurJModel';
    protected $format = 'json';

    public function index(): ResponseInterface
    {
        $data = $this->request->getJSON();
        if (!isset($data->nom) || !isset($data->mdp)) {
            return $this->respond(['message' => 'Le nom d\'utilisateur et le mot de passe sont requis.'], 400);
        }
        $username = $data->nom;
        $password = $data->mdp;
        $model = new UtilisateurJModel();
        $user = $model->where('nom', $username)->first();
        // possible password hashing here
        if ($user && $password === $user['mdp']) {
            return $this->respond(['message' => 'Authentification réussie'], 200);
        } else {
            return $this->respond(['message' => 'Nom d\'utilisateur ou mot de passe incorrect.'], 401);
        }
    }
}
