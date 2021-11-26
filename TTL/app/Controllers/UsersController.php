<?php

namespace App\Controllers;

use App\Models\UsersModel;


class UsersController extends BaseController
{
    
    public function index()
    {
        $usersModel = model(UsersModel::class);

        $data = [
            'user'  => $usersModel->getUser(),
            'title' => 'Utilisateurs inscrits',
        ];

        echo view('templates/header', $data);
        echo view('users/allUsers', $data);
        echo view('templates/footer', $data);
    }

    public function view($pseudo = null)
    {
        $usersModel = model(UsersModel::class);

        $data['user'] = $usersModel->getUser($pseudo);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the utilisateurs item: ' . $pseudo);
        }

        $data['title'] = $data['user']['U_pseudo'];

        echo view('templates/header', $data);
        echo view('users/userProfil', $data);
        echo view('templates/footer', $data);
    }

    public function subscribe()
    {
        $usersModel = model(UsersModel::class);

        if ($this->request->getMethod() === 'post'&& $this->validate([
            'email'     => 'required',
            'pass'      => 'required',
            'pseudo'    => 'required',
            'nom'       => 'required',
            'prenom'    => 'required',
        ])) {
            $usersModel->save([
                'U_mail'    => $this->request->getPost('email'),
                'U_mdp'     => $this->request->getPost('pass'),
                'U_pseudo'  => $this->request->getPost('pseudo'),
                'U_nom'     => $this->request->getPost('nom'),
                'U_prenom'  => $this->request->getPost('prenom')
            ]);

            echo view('templates/header', ['title' => 'Inscription validée']);
            echo view('privates_pages/private_index');
            echo view('templates/footer');
        } else {
            
            echo view('templates/header', ['title' => 'Formulaire d\'inscription']);
            echo view('forms/subscribe');
            echo view('templates/footer');
        }
    }
}
