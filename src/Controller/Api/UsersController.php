<?php

namespace App\Controller\Api;

use App\Controller\AppController;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use ADmad\JwtAuth\Auth\JwtAuthenticate;

class UsersController extends AppController 
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['login', 'add']);
    }

    public function index() 
    {
        $users = $this->Users->find('all');

        $this->set([
            'users' => $users,
            '_serialize' => 'users'
        ]);
    }
    
    public function loggedUser() 
    {  
        $user = JWT::decode(
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjUsIm5hbWUiOiJOYWxkc29uIiwiZXhwIjoxNTU4MjA4MTExfQ.5SRru-oVfwnnAEiS3wb_WpTzNU2-YEWNoCoj3O9aIAM',             
            Security::getSalt(),
        ['HS256']);

        $this->set([
            'user' => $user,
            '_serialize' => 'user'
        ]);
    }

    public function view($id = null) 
    {
        $user = $this->Users->get($id);

        $this->set([
            'user' => $user,
            '_serialize' => 'user'
        ]);
    }

    public function login() 
    {
        if ($this->request->is('POST')) 
        {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                $data = [
                    'token' => JWT::encode([
                        'sub' => $user['id'],
                        'name' => $user['name'],
                        'exp' => time() + 3600,
                    ], Security::salt()),
                ];

                $this->set([
                    'data' => $data,
                    '_serialize' => 'data'
                ]);
            } else {
                $message = 'Usuário ou senha inválidos';

                $this->set([
                    'message' => $message,
                    '_serialize' => 'message'
                ]);
            }
        }
    }

    public function add() 
    {
        if ($this->request->is('POST')) {

            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $message = '';

            if ($this->Users->save($user)) 
                $message = 'Usuário cadastrado com sucesso';
            else
                $message = 'Ocorreu um erro';

            $this->set([
                'message' => $message,
                '_serialize' => 'message'
            ]);
        }
    }
}