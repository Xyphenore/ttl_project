<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\SessionsModel;



class UsersController extends BaseController
{

    public function logout()
    {
        session()->destroy();
        redirect('pages/index');
    }

    public function loggin()
    {
        $usersModel = model(UsersModel::class); 

        if ($this->request->getMethod() === 'post' && $this->validate(
            [
                'email'     => 'required|valid_email',
                'pass'      => 'required|isValidLoggin[email,pass]',
            ],
            ['pass'     => ['isValidLoggin' => 'L\'email et le mot de passe ne correspondent pas']]
        )) {
            $user = $usersModel->where('U_mail', $this->request->getVar('email'))
                ->first();


            $userData = [
                'umail' => $user['U_mail'],
                'upseudo' => $user['U_pseudo'],
                'unom' => $user['U_nom'],
                'uprenom' => $user['U_prenom'],
                'isLoogedIn' => true,
            ];
            
            $userSession = session();
            $userSession->set($userData);

            // Pour sauvegarder la session en BDD
            // TODO à revoir
            $sessionsModel = model(UsersModel::class); 
            $sessionsModel->save([
                'S_idsession'   => $this->userSession->session_id, 
                'S_ipaddress'   => $this->userSession->ip_address, 
                'S_timestamp'   => $this->userSession->last_activity, 
                'S_data'        => $this->userData
            ]);

            $userSession->set_flashdata('success', 'Inscription validée');

            // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
            redirect('privates_pages/private_index');

            // Récupérer le message flash sur la nouvelle vue
            $this->userSession->flashdata('success');

            // echo view('templates/header', ['title' => 'Inscription validée']);
            // echo view('forms/authent');
            // echo view('templates/footer');
        } else {

            echo view('templates/header', ['title' => 'Formulaire d\'inscription']);
            echo view('forms/logging');
            echo view('templates/footer');
        }
    }


    public function isValidLoggin($userData)
    {
        $userModel = model(UsersModel::class);
        $user = $userModel->where('U_mail', $userData['email'])
            ->first();

        if (!$user)
            return false;

        return password_verify($userData['pass'], $user['U_mdp']);
    }

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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user item: ' . $pseudo);
        }

        $data['title'] = $data['user']['U_pseudo'];

        echo view('templates/header', $data);
        echo view('users/userProfil', $data);
        echo view('templates/footer', $data);
    }

    public function register()
    {
        $usersModel = model(UsersModel::class);

        if ($this->request->getMethod() === 'post' && $this->validate([
            'email'     => 'required|valid_email|is_unique[T_utilisateur.U_mail]',
            'pass'      => 'required',
            'confirm'   => 'required|matches[pass]',
            'pseudo'    => 'required|is_unique[T_utilisateur.U_pseudo]',
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

            $userSession = session();
            $userSession->set_flashdata('success', 'Inscription validée');

            // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
            redirect('forms/authent');

            // Récupérer le message flash sur la nouvelle vue
            $this->userSession->flashdata('success');

            // echo view('templates/header', ['title' => 'Inscription validée']);
            // echo view('forms/authent');
            // echo view('templates/footer');
        } else {

            echo view('templates/header', ['title' => 'Formulaire d\'inscription']);
            echo view('forms/register');
            echo view('templates/footer');
        }
    }
}
