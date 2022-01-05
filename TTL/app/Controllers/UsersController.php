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
        //  - l'attribut isloggedIn à disparu ou est à faux
        //  - si l'utilisateur à cliquer sur déconnecter
        if ((empty($session->isloggedIn)) || ($this->request->getMethod() === 'post')) {
            $session->destroy();
        }

        return redirect()->to('/');
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
        if (!empty($session->isloggedIn)) {
            return redirect()->to('dashboard');
        }

        $formRules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => "L'adresse mail est nécessaire",
                    'valid_email' => "L'adresse mail doit être valide",
                ],
            ],
            'pass' => [
                'rules' => 'required|isValidLogin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
                'errors' => [
                    'required' => 'Le mot de passe est nécessaire',
                    'isValidLogin' => 'Adresse email ou mot de passe incorrect',
                ]
            ]
        ];

        // L'utilisateur n'est pas connecté
        if ($this->request->getMethod() === 'post' && $this->validate($formRules)) {
            $usersModel = model(UsersModel::class);

            // Récupération des informations de l'utilisateur de la base de donnée
            $user = $usersModel->where('U_mail', $this->request->getVar('email'))->first();

            // S'il manque l'attribut isloggedIn, alors on écrase la session
            if (!$session->has('isloggedIn')) {
                // Création de la session
                $userData = [
                    'umail' => $user['U_mail'],
                    'upseudo' => $user['U_pseudo'],
                    'isAdmin' => $user['U_admin'],
                ];

                $session->set($userData);
            }

            $session->set('isloggedIn', true);

            return redirect()->to('dashboard');
        }

        echo view('templates/header', ['title' => 'Formulaire de connexion']);
        echo view('forms/login');
        echo view('templates/footer');
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

        $formRule = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[T_utilisateur.U_mail]',
                'errors' => [
                    'required' => 'Une adresse email est requise',
                    'valid_email' => "L'adresse email doit être valide",
                    'is_unique' => 'Cette adresse email est déjà utilisée',
                ]
            ],
            'nom' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Un nom de famille est nécessaire',
                ],
            ],
            'prenom' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Un prénom est nécessaire',
                ],
            ],
            'pseudo' => [
                'rules' => 'required|is_unique[T_utilisateur.U_pseudo]',
                'errors' => [
                    'required' => 'Un pseudo est nécessaire',
                    'is_unique' => 'Ce pseudo est déjà pris',
                ],
            ],

            'pass' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Un mot de passe est nécessaire',
                ],
            ],
            'confirm' => [
                'rules' => 'required|matches[pass]',
                'errors' => [
                    'required' => 'La confirmation du mot de passe est nécessaire',
                    'matches' => 'Les deux mots de passe ne sont pas identique',
                ]
            ],
        ];

        if ($this->request->getMethod() === 'post' && $this->validate($formRule)) {
            $usersModel->save([
                'U_mail' => $this->request->getPost('email'),
                'U_mdp' => password_hash($this->request->getPost('pass'), PASSWORD_BCRYPT),
                'U_pseudo' => $this->request->getPost('pseudo'),
                'U_nom' => $this->request->getPost('nom'),
                'U_prenom' => $this->request->getPost('prenom')
            ]);

            $session = session();
            $session->setFlashdata('register_success', 'Inscription validée');

            // Pour avoir le message de flash data on doit faire une redirection et non pas un echo view()
//            echo view('templates/header', ['title' => 'Formulaire de connexion']);
//            echo view('forms/loggin');
//            echo view('templates/footer');
            //return redirect()->route('named_route');

            return redirect()->to('login');

            // Récupérer le message flash sur la nouvelle vue
            // $this->userSession->flashdata('success');

            // echo view('templates/header', ['title' => 'Inscription validée']);
            // echo view('forms/authent');
            // echo view('templates/footer');
        }

        echo view('templates/header', ['title' => 'Formulaire d\'inscription']);
        echo view('forms/register');
        echo view('templates/footer');
    }


    public function userdelete() {
        $session = session();

        // Impossible d'accéder à la page de settings pour un utilisateur non connecté
        if ( empty($session->isloggedIn) ) {
            return redirect()->to('/');
        }

        if ( $session->get('isAdmin') == true ) {
            $session->setFlashdata('error_delete_admin', 'Impossible de supprimer le compte admin');
            return redirect()->to('dashboard');
        }

        if ($this->request->getMethod() === 'post' ) {
            $delete = $this->request->getPost('delete');


            if ( strtolower($delete) !== 'oui' ) {
                return redirect()->to('dashboard');
            }

            $userModel = model(UsersModel::class);
            $userModel->delete($session->umail);
            $session->destroy();

            return redirect()->to('/');
        }

        echo view('templates/header', ['title' => 'Suppression du compte']);
        echo view('users/userDelete');
        echo view('templates/footer');

    }

    /**
     * Fonction appeler par le formulaire View/users/setting_user.php
     * Elle vérifie les informations fournies par le formulaire et modifie le compte de l'utilisateur
     * @return void
     */
    public function usersetting()
    {
        // Chargement des assistances pour le formulaire et les redirections
        helper(['form', 'url']);

        $session = session();

        // Impossible d'accéder à la page de settings pour un utilisateur non connecté
        if ( !isset($session->isloggedIn) ) {
            return redirect()->to('/');
        }

        $usersModel = model(UsersModel::class);

        $email = $session->umail;

        // Récupération de l'utilisateur
        $user = $usersModel->where('U_mail', $email)->first();
        //var_dump($user);

        if ($this->request->getMethod() === 'post') {
            if ( $this->request->getPost('id-form') === 'form-identity' ) {
                $formRule = [
                    'email' => [],
                    'nom' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Le nom est nécessaire',
                        ],
                    ],
                    'prenom' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Le prénom est nécessaire',
                        ],
                    ],
                    'pseudo' => [
                        'rules' => 'required|is_unique[T_utilisateur.U_pseudo,U_mail,{email}]',
                        'errors' => [
                            'required' => 'Le pseudo est nécessaire',
                            'is_unique' => 'Ce pseudo est déjà pris',
                        ],
                    ],

                    'pass' => [
                        'rules' => 'required|isValidLogin[T_utilisateur.U_mail,T_utilisateur.U_mdp]',
                        'errors' => [
                            'required' => 'Le mot de passe actuel est nécessaire pour valider les modifications',
                            'isValidLogin' => 'Mot de passe incorrect',
                        ],
                    ],
                ];

                if ($this->validate($formRule)) {
                    // Pour tous les paramètres différents du compte actuel, update dans la base de données

                    $update_data = [];

                    // Détection du nouveau nom

                    $new_nom = $this->request->getPost('nom');

                    if ($new_nom !== $user['U_nom']) {
                        $update_data = ['U_nom' => $new_nom];
                    }

                    // Détection du nouveau prénom

                    $new_prenom = $this->request->getPost('prenom');

                    if ($new_prenom !== $user['U_prenom']) {
                        $update_data = ['U_prenom' => $new_prenom];
                    }

                    // Détection du nouveau pseudo

                    $new_pseudo = $this->request->getPost('pseudo');

                    if ($new_pseudo !== $user['U_pseudo']) {
                        $update_data = ['U_pseudo' => $new_pseudo];
                    }

                    // Mise à jour du compte utilisateur
                    if (!empty($update_data)) {
                        $usersModel->update($email,$update_data);

                        $session->setFlashdata('success_modify_identity', 'Votre identité a été mise à jour');
                        return redirect()->to('UserSetting');
                    }
                }

                //$session->setFlashdata('id-form', 'form-identity');
            }
            elseif ( $this->request->getPost('id-form') === 'form-password' ) {
                $formRule = [
                    'email' => [],
                    'pass' => [
                        'rules' => 'required|isValidLogin[email,pass]',
                        'errors' => [
                            'required' => 'Le mot de passe actuel est nécessaire pour valider les modifications',
                            'isValidLogin' => 'Mot de passe incorrect',
                        ],
                    ],

                    'new_pass' => [
                        'rules' => 'required|differs[pass]',
                        'errors' => [
                            'required' => 'Un nouveau mot de passe est requis',
                            'differs' => "Le nouveau mot de passe est identique à l'ancien",
                        ],
                    ],
                    'confirm' => [
                        'rules' => 'required|matches[new_pass]',
                        'errors' => [
                            'required' => 'La confirmation du nouveau mot de passe est requise',
                            'matches' => 'Le nouveau mot de passe et sa confirmation ne correspondent pas',
                        ],
                    ],
                ];

                if ($this->validate($formRule)) {
                    // Détection du nouveau mot de passe

                    $new_password = $this->request->getPost('new_pass');

                    if (isset($new_password)) {
                        $usersModel->update($this->request->getPost('email'), ['U_mdp' => password_hash($new_password, PASSWORD_BCRYPT)]);

                        $session->setFlashdata('success_modify_pw', 'Mot de passe modifié');
                        return redirect()->to('UserSetting');
                    }
                }

                //$session->setFlashdata('id-form', 'form-password');
            }

            $session->setFlashdata('id-form', $this->request->getPost('id-form'));
        }


        $user_array = [
            'nom' => $user['U_nom'],
            'prenom' => $user['U_prenom'],
            'pseudo' => $user['U_pseudo'],
            'mail' => $user['U_mail'],
        ];

        // Affichage de la page avec les champs remplis avec les informations du compte actuel
        echo view('templates/header', ['title' => 'Paramètre du compte']);
        echo view('users/userSetting', ['data' => $user_array]);
        echo view('templates/footer');
    }

    public function dashboard() {
        // Chargement des assistances pour le formulaire et les redirections
        helper(['form', 'url']);

        $session = session();

        // Impossible d'accéder à la page de settings pour un utilisateur non connecté
        if ( !isset($session->isloggedIn) ) {
            return redirect()->to('/');
        }


        $usersModel = model(UsersModel::class);

        $email = $session->umail;

        // Récupération de l'utilisateur
        $user = $usersModel->where('U_mail', $email)->first();

        // récupération du nombre de message non lu
        $msg['msg'] = $this->hasUnreadMessage($email);
        
        $data['tete'] = 'Votre tableau de bord';
        $data['title'] = 'Tableau de bord';
        $data['user'] = $session->umail;
        $data['pseudo'] = $session->upseudo;
        $data['prenom'] = $user['U_prenom'];
        $data['nbmsg'] =  $msg['msg']['count'];
        $data['hasmsg'] =  $msg['msg']['hasnewmsg'];
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
        $userModel = model(UsersModel::class);

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur n'est pas connecté
        if (empty($session->isloggedIn)) {
            return redirect()->to('login');
        }

        // Récupération de la valeur du bouton qui a été cliqué
        $action = $this->request->getPost('act');

        // Mise à jour de l'état de l'annonce en BDD
        if ($this->request->getMethod() === 'post') {
            switch ($action) {
                case 'Annonces';
                    return redirect()->to('privateAds');

                case 'Messages';
                    return redirect()->to('adsMessages');

                case 'Paramètre';
                    return redirect()->to('UserSetting');

                default:
                    return redirect()->to('dashboard');
            }
        }
    }

     /**
     * Notification si l'utilisateur à des messages non lus
     *
     */
    public function hasUnreadMessage($idUser)
    {
        $messageModel = model(MessageModel::class);
        $adsModel = model(AdsModel::class);

        $count = 0;

        $data['ads'] = $adsModel->getUserAds($idUser);
        
        foreach ($data['ads'] as $v) {
            $count += $messageModel->numberUnreadMessage($v['A_idannonce']);
            
        }
        
        $data['hasnewmsg'] = ($count > 0);
        $data['count'] = $count;
        
        return $data;
    }
}
