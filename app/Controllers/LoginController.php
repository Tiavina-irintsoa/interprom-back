<?php

namespace App\Controllers;

use App\Models\UtilisateurJModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use \Firebase\JWT\JWT;

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
        if ($user && password_verify($password, $user['mdp'])) {
            $payload = [
                'id' => $user['id'],
                'nom' => $user['nom'],
                'exp' => strtotime('+1 day'),
                'profil' => $user['profil']
            ];
            $jwt = JWT::encode($payload, getenv('JWT_SECRET'), 'HS256');
            return $this->respond(['message' => 'Authentification réussie','token' => $jwt], 200);
        } else {
            return $this->respond(['message' => 'Nom d\'utilisateur ou mot de passe incorrect.'], 401);
        }
    }
}
