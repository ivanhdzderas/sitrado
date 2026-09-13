<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected Session $session;

    /** @var array<string, mixed>|null */
    protected $user;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->helpers = ['form', 'url', 'text', 'app'];

        parent::initController($request, $response, $logger);

        $this->session = service('session');
        $this->user    = $this->session->get('logged_in');

        date_default_timezone_set('America/Mexico_City');
    }

    protected function render(string $view, array $data = [], string $title = 'Sistema Documental')
    {
        return view('layouts/main', [
            'title'   => $title,
            'user'    => $this->user,
            'content' => view($view, array_merge($data, ['user' => $this->user])),
        ]);
    }

    protected function isAdmin(): bool
    {
        return ($this->user['tipo'] ?? '') === 'admin';
    }

    protected function requireAdmin()
    {
        if (! $this->isAdmin()) {
            return redirect()->to('/inicio')->with('error', 'No tienes permisos para esta sección.');
        }

        return null;
    }
}
