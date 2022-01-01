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

        if ( isset($session->isLoogedIn) ) {
            if ($this->request->getMethod() === 'post') {
                $session->destroy();
            }
            else {
                echo view('templates/header', ['title' => 'Bouton de déconnexion']);
                echo view('forms/logout');
                echo view('templates/footer');
            }
        }

        return redirect()->to('index');
    }

    public function loggin()
    {
        helper(['form', 'url']);


        // Init de la session
        $session = session();

        // Alors on crée la session
        // Donc il faut se connecter

        if ( !isset($session->isLoogedIn) ) {
            if ($this->request->getMethod() === 'post' && $this->validate(
                    [
                        'email' => 'required|valid_email',
                        'pass' => 'required|isValidLoggin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
                    ],
                    ['pass' => ['isValidLoggin' => 'L\'email et le mot de passe ne correspondent pas']]
                )) {

//                return redirect()->to('forms/logout');

                $usersModel = model(UsersModel::class);

                $email = $this->request->getVar('email');
                //$email = 'admin@domaine.com';

                // Récupération des informations de l'utilisateur de la base de donnée
                $user = $usersModel->where('U_mail', $email)->first();



                // Création de la session
                $userData = [
                    'umail' => $user['U_mail'],
                    'upseudo' => $user['U_pseudo'],
//                'unom' => $user['U_nom'],
//                'uprenom' => $user['U_prenom'],
                    'isLoogedIn' => true,
                    'isAdmin' => $user['u_admin'],
                ];

                $session->set($userData);

                // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
                echo view('templates/header', ['title' => 'Index privé']);
                echo view('privates/private_index');
                echo view('templates/footer');

                // Récupérer le message flash sur la nouvelle vue
                $session->flashdata('success');

                // echo view('templates/header', ['title' => 'Inscription validée']);
                // echo view('forms/authent');
                // echo view('templates/footer');
            } else {
                echo view('templates/header', ['title' => 'Formulaire de connexion']);
                echo view('forms/loggin');
                echo view('templates/footer');
            }
        }
        else {
            // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
            echo view('templates/header', ['title' => 'Index privé']);
            echo view('privates/private_index');
            echo view('templates/footer');

            // Récupérer le message flash sur la nouvelle vue
            //$session->flashdata('success');

            // echo view('templates/header', ['title' => 'Inscription validée']);
            // echo view('forms/authent');
            // echo view('templates/footer');
        }

        //redirect('pages/index');



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

    /**
     * Fonction appeler par le formulaire View/users/setting_user.php
     * Elle vérifie les informations fournies par le formulaire et modifie le compte de l'utilisateur
     * @return void
     */
    public function setting_user() {
        // Chargement des assistances pour le formulaire et les redirections
        helper(['form', 'url']);

        $session = session();

        // TODO à enlever
        $session->set(['umail' => 'admin@domaine.com']);

        // TODO Dé commenter
        // Impossible d'accéder à la page de settings pour un utilisateur non connecté
//        if ( !isset($session->isLoogedIn) ) {
//            return redirect()->to('index');
//        }

        $usersModel = model(UsersModel::class);

        $email = $session->umail;

        // Récupération de l'utilisateur
        $user = $usersModel->where('U_mail', $email)->first();
        var_dump($user);

        $user_array = [
            'nom' => $user['U_nom'],
            'prenom' => $user['U_prenom'],
            'pseudo' => $user['U_pseudo'],
            'mail' => $user['U_mail'],
        ];


        $formRule = [
            'nom' => [
                'rules' => 'required',
                'errors' => 'Le nom est nécessaire',
            ],
            'prenom' => [
                'rules' => 'required',
                'errors' => 'Le prenom est nécessaire',
            ],
            'pseudo' => [
                'rules' => 'required|isUniquePseudo[T_utilisateur.U_pseudo]',
                'errors' => [
                    'required' => 'Le pseudo est nécessaire',
                    'isUniquePseudo[T_utilisateur.U_pseudo]' => 'Ce pseudo est déjà pris',
                ]
            ],

            'pass' => [
                'rules' => '',
                'errors' => "Le nouveau mot de passe est identique à l'ancien",
            ],
            'confirm' => [
                'rules' => 'matches[pass]',
                'errors' => [
                    'matches[pass]' => 'Le nouveau mot de passe et sa confirmation ne correspondent pas'
                ],
            ],

            'pass_now' => [
                'rules' => 'required|isValidLoggin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
                'errors' => [
                    'Le mot de passe actuel est nécessaire pour valider les modifications',
                ],
            ],
        ];

        // Affichage de la page avec les champs remplis avec les informations du compte actuel
        echo view('templates/header', ['title' => 'Paramètre du compte']);
        echo view('users/setting_user', ['data' => $user_array]);
        echo view('templates/footer');

        // TODO : Faire la validation du pseudo isUnique

        if ( ($this->request->getMethod() === 'post') && ($this->validate($formRule)) ) {
            // Pour tous les paramètres différents du compte actuel, update dans la base de données

            $update_data = [];

            // Détection du nouveau mot de passe

            $new_password = $this->request->getVar('pass');

            if ( isset($new_password) ) {
                $update_data = ['U_mdp' => $new_password];
            }

            // Détection du nouveau nom

            $new_nom = $this->request->getVar('nom');

            if ( $new_nom !== $user->U_nom ) {
                $update_data = ['U_nom' => $new_nom];
            }

            // Détection du nouveau prénom

            $new_prenom = $this->request->getVar('prenom');

            if ( $new_prenom !== $user->U_prenom ) {
                $update_data = ['U_prenom' => $new_prenom];
            }

            // Détection du nouveau pseudo

            $new_pseudo = $this->request->getVar('pseudo');

            if ( $new_pseudo !== $user->U_pseudo ) {
                $update_data = ['U_pseudo' => $new_pseudo];
            }

            // Mise à jour du compte utilisateur
            if ( !empty($update_data) ) {
                $usersModel->update($update_data);
            }
        }
    }
}
