<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AdsModel;
use App\Models\SessionsModel;



class UsersController extends BaseController
{

    public function logout()
    {
        $session = session();

        if ( isset($session) ) {
            $session->destroy();
        }

        redirect('pages/index');
    }

    public function loggin()
    {
        // Init de la session
        $session = session();

        if ( !isset($session) ) {
            // Alors on crée la session
            // Donc il faut se connecter

            if ($this->request->getMethod() === 'post' && $this->validate(
                [
                    'email'     => 'required|valid_email',
                    'pass'      => 'required|isValidLoggin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
                ],
                ['pass'     => ['isValidLoggin' => 'L\'email et le mot de passe ne correspondent pas']]
            )) {

                $usersModel = model(UsersModel::class);

                // Récupération des informations de l'utilisateur de la base de donnée
                $user = $usersModel->where('U_mail', $this->request->getVar('email'))->first();


                // Création de la session
                $userData = [
                    'umail' => $user['U_mail'],
                    'upseudo' => $user['U_pseudo'],
//                'unom' => $user['U_nom'],
//                'uprenom' => $user['U_prenom'],
                    'isLoogedIn' => true,
                    'isAdmin' => $user['u_admin'],
                ];

                // $session->set($userData);
            }
        }

        redirect('pages/index');



//        $usersModel = model(UsersModel::class);
//
//        if ($this->request->getMethod() === 'post' && $this->validate(
//                [
//                    'email'     => 'required|valid_email',
//                    'pass'      => 'required|isValidLoggin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
//                ],
//                ['pass'     => ['isValidLoggin' => 'L\'email et le mot de passe ne correspondent pas']]
//            )) {
//            // Récupération des informations de l'utilisateur de la base de donnée
//            $user = $usersModel->where('U_mail', $this->request->getVar('email'))
//                ->first();
//
//
//            // Création de la session
//            $userData = [
//                'umail' => $user['U_mail'],
//                'upseudo' => $user['U_pseudo'],
////                'unom' => $user['U_nom'],
////                'uprenom' => $user['U_prenom'],
//                'isLoogedIn' => true,
//                'isAdmin' => $user['u_admin'],
//            ];
//
////            $userSession = session();
////            $userSession->set($userData);
//            $this->session->set($userData);
//
//            // Sauvegarde de la session
//
//
////            // Pour sauvegarder la session en BDD
////            // TODO à revoir
////            $sessionsModel = model(UsersModel::class);
////            $sessionsModel->save([
////                'S_idsession'   => $this->userSession->session_id,
////                'S_ipaddress'   => $this->userSession->ip_address,
////                'S_timestamp'   => $this->userSession->last_activity,
////                'S_data'        => $this->userData
////            ]);
////
////            $userSession->set_flashdata('success', 'Inscription validée');
////
////            // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
////            echo view('templates/header', ['title' => 'Index privé']);
////            echo view('privates/private_index');
////            echo view('templates/footer');
////
////            // Récupérer le message flash sur la nouvelle vue
////            $userSession->flashdata('success');
////
////            // echo view('templates/header', ['title' => 'Inscription validée']);
////            // echo view('forms/authent');
////            // echo view('templates/footer');
//        } else {
//
//            echo view('templates/header', ['title' => 'Formulaire de connexion']);
//            echo view('forms/loggin');
//            echo view('templates/footer');
//        }
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
        $adsModel = model(AdsModel::class);

        $data['user'] = $usersModel->getUser($pseudo);

        if (empty($data['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user item: ' . $pseudo);
        }

        $data['title'] = $data['user']['U_pseudo'];

        // Les annonces de cet utilisateur (état publié ou non)
        $data['ads'] = $adsModel->getUserAds($data['user']['U_mail']);

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

            // $userSession = session();
            // $userSession->set_flashdata('success', 'Inscription validée');

            // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
            echo view('templates/header', ['title' => 'Formulaire de connexion']);
            echo view('forms/loggin');
            echo view('templates/footer');
            //return redirect()->route('named_route');

            // Récupérer le message flash sur la nouvelle vue
            // $this->userSession->flashdata('success');

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
