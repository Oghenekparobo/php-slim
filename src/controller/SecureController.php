<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class SecureController extends Controller
{
    public function default (Request $request, Response $response)
    {

        if ($this->ci->get('session')->get('user') == null) {
            return $response->withRedirect('/');
        }

        return $this->render($response, 'default.html', [
            'user' => $this->ci->get('session')->get('user')
        ]);
    }

    public function status(Request $request, Response $response)
    {
        return $this->render($response, 'status.html');
    }
}