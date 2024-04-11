<?php

namespace App\Controllers;

use App\Models\DisciplineJModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DisciplineJController
{
    public function index(Request $request, Response $response, $args)
    {
        $disciplines = DisciplineJModel::all();

        return $response->withJson($disciplines);
    }

    public function show(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $discipline = DisciplineJModel::find($id);

        if (!$discipline) {
            return $response->withStatus(404)->withJson(['message' => 'Discipline not found']);
        }

        return $response->withJson($discipline);
    }

    public function store(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        $discipline = new DisciplineJModel();
        $discipline->nom = $data['nom'];
        $discipline->save();

        return $response->withJson($discipline);
    }

    public function update(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

        $discipline = DisciplineJModel::find($id);

        if (!$discipline) {
            return $response->withStatus(404)->withJson(['message' => 'Discipline not found']);
        }

        $discipline->nom = $data['nom'];
        $discipline->save();

        return $response->withJson($discipline);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $id = $args['id'];

        $discipline = DisciplineJModel::find($id);

        if (!$discipline) {
            return $response->withStatus(404)->withJson(['message' => 'Discipline not found']);
        }

        $discipline->delete();

        return $response->withJson(['message' => 'Discipline deleted']);
    }
}
