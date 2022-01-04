<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AdsModel;



class UsersController extends BaseController
{

    /**
     * Fonction pour la vue /Views/forms/logout
     * Propose à l'utilisateur de se déconnecter en cliquant sur le bouton
     * Détruit la session créée pour cet utilisateur
     * Redirige vers la page d'accueil du site après l'opération, ou si l'utilisateur n'a pas de session valide
     * @return RedirectResponse|null
     * @version 1.0
     * @see /Views/forms/logout
     */
    public function logout()
    {
        // Identification de l'utilisateur
        $session = session();

        // Dans le cas :
        //  - l'attribut isLoggedIn à disparu ou est à faux
        //  - si l'utilisateur à cliquer sur déconnecter
        if ((empty($session->isLoggedIn)) || ($this->request->getMethod() === 'post')) {
            $session->destroy();
            return redirect()->to('index');
        }
        $session->destroy();
        return redirect()->to('index');
        // echo view('forms/logout', ['title' => 'logout']);

        //
    }

    /**
     * Fonction pour la vue /Views/forms/login
     * Permet à l'utilisateur de se connecter à son espace
     * Crée une nouvelle session
     * Redirige vers l'espace du membre si la connexion est valide
     * @return RedirectResponse
     * @version 1.0
     * @see /Views/forms/login
     */
    public function login()
    {
        helper(['form', 'url']);
        // On récupère la session actuelle
        $session = session();

        // Si déjà connecté alors on accède l'espace
        if (!empty($session->isLoggedIn)) {
            return redirect()->to('dashboard');
        }

        // L'utilisateur n'est pas connecté
        if ($this->request->getMethod() === 'post' && $this->validate(
            [
                'email' => 'required|valid_email',
                'pass' => 'required|isValidlogin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
            ],
            ['pass' => ['isValidlogin' => 'L\'email et le mot de passe ne correspondent pas']]
        )) {
            $usersModel = model(UsersModel::class);

            // Récupération des informations de l'utilisateur de la base de donnée
            $user = $usersModel->where('U_mail', $this->request->getVar('email'))->first();

            // S'il manque l'attribut isLoggedIn, alors on écrase la session
            if (!$session->has('isLoggedIn')) {
                // Création de la session
                $userData = [
                    'umail' => $user['U_mail'],
                    'upseudo' => $user['U_pseudo'],
                    'isAdmin' => $user['U_admin'],
                ];

                $session->set($userData);
            }

            $session->set('isLoggedIn', true);

            return redirect()->to('dashboard');
        }

        echo ($this->request->getMethod());

        // Affichage de la page
        $data = [
            'title' => 'Connexion',
            'signin' => site_url('register'),
        ];

        $data['tete'] = 'Formulaire de connexion';


        echo view('templates/header', ['title' => 'Formulaire de connexion']);
        echo view('forms/login', ['data' => $data]);
        echo view('templates/footer');

        // Nécessaire pour PHP 8.0, si on arrive là on affiche juste la page
        return null;
    }


    public function index()
    {
        $usersModel = model(UsersModel::class);
        $adsModel = model(AdsModel::class);


        $tmp = [
            'user'  => $usersModel->getUser(),
            'title' => 'Utilisateurs inscrits',
        ];

        $tmp2 = [];
        // Récupération du nombre d'annonces publiées par l'utilisateur
        foreach ($tmp['user'] as $k => $v) {

            $count['count'] = $adsModel->getNumberads($v['U_mail']);
            $tmp2[] = array_merge($v, $count);
        }


        $data['user'] = $tmp2;
        $data['title'] = 'Utilisateurs';
        $data['tete'] = 'Utilisateurs inscrits';

        echo view('templates/header', $data);
        echo view('users/allUsers', $data);
        echo view('templates/footer', $data);
    }

    public function view($pseudo = null)
    {
        $usersModel = model(UsersModel::class);
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);

        $tmp['user'] = $usersModel->getUser($pseudo);

        if (empty($tmp['user'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the user item: ' . $pseudo);
        }



        // Les annonces de cet utilisateur (état public)
        $tmp['ads'] = $adsModel->getUserAds($tmp['user']['U_mail'], 0, 0, "public");


        $tmp2 = [];
        // TODO faire plutôt des jointures en BDD
        foreach ($tmp['ads'] as $k => $v) {
            if (!empty($photoModel->getAdsPhoto($v['A_idannonce'], true))) {
                $photo = $photoModel->getAdsPhoto($v['A_idannonce'], true);
                $tmp2[] = array_merge($v, $photo);
            } else {
                $tmp2[] = $v;
            }
        }

        $data['title'] = $tmp['user']['U_pseudo'];
        $data['tete'] = $tmp['user']['U_pseudo'];
        $data['user'] = $tmp['user'];
        $data['ads'] = $tmp2;

        echo view('templates/header', $data);
        echo view('users/userProfil', $data);
        echo view('templates/footer', $data);
    }

    public function register()
    {
        helper(['form', 'url']);

        $usersModel = model(UsersModel::class);
        $data['title'] = 'Formulaire d\'inscription';

        if ($this->request->getMethod() === 'post' && $this->validate([
            'email' => 'required|valid_email|is_unique[T_utilisateur.U_mail]',
            'pass' => 'required',
            'confirm' => 'required|matches[pass]',
            'pseudo' => 'required|is_unique[T_utilisateur.U_pseudo]',
            'nom' => 'required',
            'prenom' => 'required',
        ])) {
            $usersModel->save([
                'U_mail' => $this->request->getPost('email'),
                'U_mdp' => password_hash($this->request->getPost('pass'), PASSWORD_BCRYPT),
                'U_pseudo' => $this->request->getPost('pseudo'),
                'U_nom' => $this->request->getPost('nom'),
                'U_prenom' => $this->request->getPost('prenom')
            ]);

            // $userSession = session();
            // $userSession->set_flashdata('success', 'Inscription validée');

            // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
            //            echo view('templates/header', ['title' => 'Formulaire de connexion']);
            //            echo view('forms/login');
            //            echo view('templates/footer');
            //return redirect()->route('named_route');

            return redirect()->to('login');

            // Récupérer le message flash sur la nouvelle vue
            // $this->userSession->flashdata('success');

            // echo view('templates/header', ['title' => 'Inscription validée']);
            // echo view('forms/authent');
            // echo view('templates/footer');
        } else {

            echo view('templates/header', $data);
            echo view('forms/register');
            echo view('templates/footer');
        }
    }

    /**
     * Fonction appeler par le formulaire View/users/UserSetting.php
     * Elle vérifie les informations fournies par le formulaire et modifie le compte de l'utilisateur
     * @return void
     */
    public function usersetting()
    {
        // Chargement des assistances pour le formulaire et les redirections
        helper(['form', 'url']);

        $session = session();

        // Impossible d'accéder à la page de settings pour un utilisateur non connecté
        if (!isset($session->isLoggedIn)) {
            return redirect()->to('index');
        }

        $usersModel = model(UsersModel::class);

        $email = $session->umail;

        // Récupération de l'utilisateur
        $user = $usersModel->where('U_mail', $email)->first();
        

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
                'rules' => 'required|is_unique[T_utilisateur.U_pseudo,email,{email}]',
                'errors' => [
                    'required' => 'Le pseudo est nécessaire',
                    'is_unique[T_utilisateur.U_pseudo,email,{email}]' => 'Ce pseudo est déjà pris',
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
                'rules' => 'required|isValidlogin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
                'errors' => [
                    'Le mot de passe actuel est nécessaire pour valider les modifications',
                ],
            ],
        ];

        // Affichage de la page avec les champs remplis avec les informations du compte actuel
        echo view('templates/header', ['title' => 'Paramètre du compte']);
        echo view('users/userSetting', ['data' => $user_array]);
        echo view('templates/footer');

        if (($this->request->getMethod() === 'post') && ($this->validate($formRule))) {
            // Pour tous les paramètres différents du compte actuel, update dans la base de données

            $update_data = [];

            // Détection du nouveau mot de passe

            $new_password = $this->request->getVar('pass');

            if (isset($new_password)) {
                $update_data = ['U_mdp' => $new_password];
            }

            // Détection du nouveau nom

            $new_nom = $this->request->getVar('nom');

            if ($new_nom !== $user->U_nom) {
                $update_data = ['U_nom' => $new_nom];
            }

            // Détection du nouveau prénom

            $new_prenom = $this->request->getVar('prenom');

            if ($new_prenom !== $user->U_prenom) {
                $update_data = ['U_prenom' => $new_prenom];
            }

            // Détection du nouveau pseudo

            $new_pseudo = $this->request->getVar('pseudo');

            if ($new_pseudo !== $user->U_pseudo) {
                $update_data = ['U_pseudo' => $new_pseudo];
            }

            // Mise à jour du compte utilisateur
            if (!empty($update_data)) {
                $usersModel->update($update_data);
            }
        }
    }

    public function dashboard()
    {
        // Chargement des assistances pour le formulaire et les redirections
        helper(['form', 'url']);

        $session = session();

        // Impossible d'accéder à la page de settings pour un utilisateur non connecté
        if (!isset($session->isLoggedIn)) {
            return redirect()->to('/');
        }


        $usersModel = model(UsersModel::class);

        $email = $session->umail;

        // Récupération de l'utilisateur
        $user = $usersModel->where('U_mail', $email)->first();
        

        // $data = [
        //     'user' => $session->umail,
        //     'pseudo' => $session->upseudo,
        //     'prenom' => $user['U_prenom'],
        //     'annonces' => site_url('ads/privateAds'),
        //     'discussion' => site_url('users/messages'),
        //     'parametre' => site_url('users/UserSetting'),
        //     'supprimer' => site_url('users/delete_account'),
        // ];
        $data['tete'] = 'Votre tableau de bord';
        $data['title'] = 'Tableau de bord';
        $data['user'] = $session->umail;
        $data['pseudo'] = $session->upseudo;
        $data['prenom'] = $user['U_prenom'];

        // Affichage de la page avec les champs remplis avec les informations du compte actuel
        echo view('templates/header', $data);
        echo view('users/dashboard', $data);
        echo view('templates/footer', $data);
    }

    /**
     * Switch la valeur du bouton cliqué et redirige l'utilisateur de manière adequate
     *
     * @return void
     */
    public function actionDashboard()
    {
        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur n'est pas connecté
        if (empty($session->isLoggedIn))
            return redirect()->to('login');
        
        // Récupération de la valeur du bouton qui a été cliqué
        $action = $this->request->getPost('act');

        if ($this->request->getMethod() === 'post') {
            switch ($action) {
                case 'Modifier mon compte';
                    return redirect()->to('UserSetting');

                case 'Supprimer mon compte';
                    $userModel = model(UsersModel::class);
                    $session->destroy();
                    $userModel->delete($session->umail);
                    return redirect()->to('allAds');

                default:
                    $this->dashboard();
                    break;
            }
        }
    }
}
