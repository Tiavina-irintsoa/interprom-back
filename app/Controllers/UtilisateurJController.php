<?php

namespace App\Controllers;

use App\Models\UtilisateurJModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class UtilisateurJController extends ResourceController
{
    protected $modelName = 'App\Models\UtilisateurJModel';
    protected $format = 'json';

    // -X GET
    public function index(): ResponseInterface
    {
        $model = new UtilisateurJModel();
        $utilisateurs = $model->findAll();

        return $this->respond($utilisateurs);
    }

    // -X POST
    public function create(): ResponseInterface
    {
        helper(['form', 'url']);
        $model = new UtilisateurJModel();
        $data = $this->request->getJSON();
        $rules = [
            'nom' => 'required|min_length[2]',
            'mdp' => 'required|min_length[8]|regex_match[/^\S*$/]',
        ];
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $dataArray = (array) $data;
        $dataArray['mdp'] = password_hash($dataArray['mdp'], PASSWORD_DEFAULT);
        if ($model->insert($dataArray)) {
            return $this->respondCreated(['message' => 'Utilisateur créé avec succès']);
        } else {
            return $this->failServerError('Erreur lors de la création de l\'utilisateur');
        }
    }

    public function show($id = null): ResponseInterface
    {
        $model = new UtilisateurJModel();
        $utilisateur = $model->find($id);

        if ($utilisateur) {
            return $this->respond($utilisateur);
        } else {
            return $this->failNotFound('Utilisateur non trouvé');
        }
    }

    public function update($id = null): ResponseInterface
    {
        $model = new UtilisateurJModel();
        $data = $this->request->getJSON();

        if ($model->update($id, $data)) {
            return $this->respond(['message' => 'Utilisateur mis à jour avec succès']);
        } else {
            return $this->failServerError('Erreur lors de la mise à jour de l\'utilisateur');
        }
    }

    // -X DELETE
    public function delete($id = null): ResponseInterface
    {
        $model = new UtilisateurJModel();

        if ($model->delete($id)) {
            return $this->respondDeleted(['message' => 'Utilisateur supprimé avec succès']);
        } else {
            return $this->failServerError('Erreur lors de la suppression de l\'utilisateur');
        }
    }
}
