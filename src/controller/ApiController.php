<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ApiController extends Controller
{

    public function default (Request $request, Response $response)
    {
        $albums = json_decode(file_get_contents(__DIR__ . '/../../data/albums.json'), true);

        return $this->render($response, 'default.html', [
            'albums' => $albums
        ]);
    }



    public function search(Request $request, Response $response)
    {
        $albums = json_decode(file_get_contents(__DIR__ . '/../../data/albums.json'), true);

        $query = $request->getQueryParam('q');



        if ($query) {
            $albums = array_values(array_filter($albums, function ($album) use ($query) {
                return strpos($album['title'], $query) !== false || strpos($album['artist'], $query) !== false;
            }));
        }

        if($query === ''){
            return $response->withStatus(400)->withJson(['error'=>'invalid request']);


        }

        return $response->withJson($albums);



    }



}