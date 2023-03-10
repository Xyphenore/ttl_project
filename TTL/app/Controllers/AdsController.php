<?php

namespace App\Controllers;

use App\Models\AdsModel;
use App\Models\PhotoModel;
use App\Models\UsersModel;

class AdsController extends BaseController
{

    /**
     * vue par défaut de la page d'accueil
     *
     * @return void
     */
    public function index()
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);
        $usersModel = model(UsersModel::class);

        $tmp = [
            'ads'   => $adsModel->getAds(null, 6, 0, 'Public'),
            'tete' => 'Les dernières annonces publiées',
        ];
        $tmp2 = [];
        // Bidouillage pour fusionner en une seule ligne les 3 requetes
        // Les jointures sous codeigniter c'est douloureux !
        foreach ($tmp['ads'] as $k => $v) {
            // récupération des Propiétaire et photo rattachées à chaque annonce
            $owner = $usersModel->getAdsOwner($v['U_mail'], true);

            if (!empty($photoModel->getAdsPhoto($v['A_idannonce'], true))) {
                $photo = $photoModel->getAdsPhoto($v['A_idannonce'], true);
                $tmp2[] = array_merge($v, $owner, $photo);
            } else {
                $tmp2[] = array_merge($v, $owner);
            }
        }
        $data = [
            'ads'   => $tmp2,
            'tete' => 'Les dernières annonces publiées',
            'title' => 'Accueil',
        ];

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isloggedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {

            $data['iduser'] = null;
            $data['pseudo'] = null;
        }

        echo view('templates/header', $data);
        echo view('ads/index', $data);
        echo view('templates/footer', $data);
    }

    public function globalView()
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);

        $usersModel = model(UsersModel::class);

        $tmp = [
            'ads'   => $adsModel->getAds(null, 0, 0, 'Public'),
            'tete' => 'Les dernières annonces publiées',
        ];

        // Bidouillage pour fusionner en une seule ligne les 3 requetes
        // Les jointures sous codeigniter c'est douloureux !
        foreach ($tmp['ads'] as $k => $v) {
            // récupération des Propiétaire et photo rattachées à chaque annonce
            $owner = $usersModel->getAdsOwner($v['U_mail'], true);

            if (!empty($photoModel->getAdsPhoto($v['A_idannonce'], true))) {
                $photo = $photoModel->getAdsPhoto($v['A_idannonce'], true);
                $tmp2[] = array_merge($v, $owner, $photo);
            } else {
                $tmp2[] = array_merge($v, $owner);
            }
        }
        $data = [
            'ads'   => $tmp2,
            'tete' => 'Toutes les annonce actuellement publiées',
            'title' => 'Annonces en ligne',
        ];

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isloggedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {

            $data['iduser'] = null;
            $data['pseudo'] = null;
        }

        echo view('templates/header', $data);
        echo view('ads/index', $data);
        echo view('templates/footer', $data);
    }


    public function detailView($idAnnonce = null)
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);
        $usersModel = model(UsersModel::class);

        $data['ads'] = $adsModel->getAds($idAnnonce);
        $data['title'] = 'Détail de l\'annonce';

        if (empty($data['ads'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Impossible de trouver l\'annonce: ' . $idAnnonce);
        }

        $data['tete'] = $data['ads']['A_titre'];
        // récupération de la photo vitrine rattachées à l'annonce
        $data['vitrine'] = $photoModel->getAdsPhoto($data['ads']['A_idannonce'], true);
        // récupération des 4 autres photos éventuelles rattachées à l'annonce
        $data['photos'] = $photoModel->getAdsPhoto($data['ads']['A_idannonce'], false);
        // récupération du propriétaire de l'annonce
        $data['owner']  = $usersModel->getAdsOwner($data['ads']['U_mail']);

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isloggedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {

            $data['iduser'] = null;
            $data['pseudo'] = null;
        }


        echo view('templates/header',  $data);
        echo view('ads/detailAds', $data);
        echo view('templates/footer', $data);
    }


    public function privateView()
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);
        $messageModel = model(MessageModel::class);


        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isloggedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {

            $data['iduser'] = null;
            $data['pseudo'] = null;
        }

        // Toutes les annonces quel que soit leur état
        $tmp = ['ads'  => $adsModel->getUserAds($session->umail)];

        $tmp2 = [];
        $count = [];
        // fusion des requetes
        // TODO faire cette manip en requete dans la base de données
        foreach ($tmp['ads'] as $k => $v) {

            // Récupère le nombre de message non lu
            $count['count'] = $messageModel->numberUnreadMessage($v['A_idannonce']);
            if (!empty($photoModel->getAdsPhoto($v['A_idannonce'], true))) {
                $photo = $photoModel->getAdsPhoto($v['A_idannonce'], true);
                $tmp2[] = array_merge($v, $photo, $count);
            } else {
                $tmp2[] = array_merge($v, $count);
            }
        }

        $data['ads'] =  $tmp2;
        $data['tete'] = 'Vos annonces';
        $data['title'] = $session->upseudo;

        echo view('templates/header', $data);
        echo view('ads/privateAds', $data);
        echo view('templates/footer', $data);
    }

    /**
     * Création d'une annonce
     *
     * @return void
     */
    public function createAds()
    {
        $adsModel = model(AdsModel::class);
        $data['tete'] = 'création d\'une annonce';
        $data['title'] = 'Nouvelle annonce';

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isloggedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {
            return redirect()->to('login');
        }

        if ($this->request->getPost('submit') === "Publier")
            $etat = "Public";
        else
            $etat = "Brouillon";


        // Sauvegarde des champs saisis
        $data['ads'] = [
            'titre'         => $this->request->getPost('titre'),
            'loyer'         => $this->request->getPost('loyer'),
            'charges'       => $this->request->getPost('charges'),
            'chauffage'     => $this->request->getPost('chauffage'),
            'superficie'    => $this->request->getPost('superficie'),
            'description'   => $this->request->getPost('description'),
            'adresse'       => $this->request->getPost('adresse'),
            'ville'         => $this->request->getPost('ville'),
            'cp'            => $this->request->getPost('cp'),
            'energie'       => $this->request->getPost('energie'),
            'type'          => $this->request->getPost('type'),
        ];

        $formRules = [
            'titre' => [
                'rules' => 'required|min_length[3]|max_length[128]',
                'errors' => [
                    'required' => "Un titre pour l'annonce est nécessaire",
                    'min_length' => "Le titre doit faire un minimum de 3 caractères",
                    'max_length' => "Le titre peut au maximum faire 128 caractères",
                ],
            ],
            'loyer' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Le loyer est requis",
                ],
            ],
            'chauffage' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Le choix du chauffage est nécessaire",
                ],
            ],
            'superficie' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "La superficie est nécessaire",
                ],
            ],
            'type' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Le type de chauffage doit être sélectionné",
                ],
            ],
            'adresse' => [
                'rules' => 'required|max_length[128]',
                'errors' => [
                    'required' => "L'adresse est nécessaire",
                    'max_length' => "L'adresse peut faire au maximum 128 caractères",
                ],
            ],
            'ville' => [
                'rules' => 'required|max_length[128]',
                'errors' => [
                    'required' => "La ville est nécessaire",
                    'max_length' => "La ville peut faire au maximum 128 caractères",
                ],
            ],
            'cp' => [
                'rules' => 'required|exact_length[5]|numeric',
                'errors' => [
                    'required' => "Le code postal est nécessaire",
                    'exact_length' => "Le code postal doit faire 5 chiffres",
                    'numeric' => "Le code postal doit être un nombre",
                ],
            ],
        ];

        //        [
        //            'titre'      => 'required|min_length[3]|max_length[128]',
        //            'loyer'      => 'required',
        //            'chauffage'  => 'required',
        //            'superficie' => 'required',
        //            'type'       => 'required',
        //            'adresse'    => 'required|max_length[128]',
        //            'ville'      => 'required|max_length[128]',
        //            'cp'         => 'required|min_length[5]|max_length[5]',
        //        ]

        if ($this->request->getMethod() === 'post' && $this->validate($formRules)) {

            $adsModel->save([
                'A_titre'            => $data['ads']['titre'],
                'A_cout_loyer'       => $data['ads']['loyer'],
                'A_cout_charges'     => $data['ads']['charges'],
                'A_type_chauffage'   => $data['ads']['chauffage'],
                'A_superficie'       => $data['ads']['superficie'],
                'A_description'      => $data['ads']['description'],
                'A_adresse'          => $data['ads']['adresse'],
                'A_ville'            => $data['ads']['ville'],
                'A_CP'               => $data['ads']['cp'],
                'E_idenergie'        => $data['ads']['energie'],
                'T_type'             => $data['ads']['type'],
                'U_mail'             => $data['iduser'],
                'A_etat'             => $etat,
            ]);

            //  redirige vers
            $this->privateView($data['iduser']);
        } else {
            echo view('templates/header', $data);
            echo view('ads/createAds', $data);
            echo view('templates/footer', $data);
        }
    }

    /**
     * Fonction d'action sur une annonce
     * Change l'état de l'annonce
     */
    public function actionAds()
    {
        $adsModel = model(AdsModel::class);
        $data['tete'] = 'Action sur annonce';
        $data['title'] = 'Action';

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isloggedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {
            return redirect()->to('login');
        }

        // Récupération de l'id depuis le formulaire
        $idAnnonce = $this->request->getPost('id');
        $data['ads'] = $adsModel->getAds($idAnnonce);
        $action = $this->request->getPost('act');

        // Mise à jour de l'état de l'annonce en BDD
        if ($this->request->getMethod() === 'post') {

            switch ($action) {
                case 'Publier';
                    $adsModel->update($idAnnonce, ['A_etat' => "Public"]);
                    return redirect()->to('privateAds');
                case 'Voir';
                    return redirect()->to('ads/' . $idAnnonce);
                    // $this->detailView($idAnnonce);
                    // break;
                case 'Supprimer';
                    $adsModel->delete($idAnnonce);
                    return redirect()->to('privateAds');

                case 'Archiver';
                    $adsModel->update($idAnnonce, ['A_etat' => "Archive"]);
                    return redirect()->to('privateAds');

                case 'Brouillon';
                    $adsModel->update($idAnnonce, ['A_etat' => "Brouillon"]);
                    return redirect()->to('privateAds');

                case 'Modifier';
                // $this->updateAds($this->request->getPost('id'));
                    $data['tete'] = 'Modification de l\'annonce';
                    $data['title'] = 'Edition annnonce';
                    $data['idAnnonce'] = $this->request->getPost('id');
                    echo view('templates/header', $data);
                    echo view('ads/updateAds', $data);
                    echo view('templates/footer');
                    break;
                default:
                    $adsModel->update($idAnnonce, ['A_etat' => "Brouillon"]);
                    break;
            }
        }
    }

    /**
     * Modification d'une annonce
     *
     * @return void
     */
    public function updateAds($idannonce = null)
    {
        $data['tete'] = 'Modification d\'une annonce';
        $data['title'] = 'Edition annonce';
        $data['idAnnonce'] = $this->request->getPost('id');
        // On récupère la session actuelle
        $session = session();

        $action = $this->request->getPost('act');

        if ($idannonce == null)
            $idannonce = $this->request->getPost('id');

        switch ($action) {
            case 'Annuler';
                return redirect()->to('privateAds');
            case 'Valider';
                $adsModel = model(AdsModel::class);
                $photoModel = model(PhotoModel::class);
                if ($this->request->getMethod() === 'post' && $this->validate([
                    'title'      => 'required|min_length[3]|max_length[128]',
                    'loyer'      => 'required',
                    'chauffage'  => 'required',
                    'superficie' => 'required',
                    'type'       => 'required',
                    'adresse'    => 'required|max_length[128]',
                    'ville'      => 'required|max_length[128]',
                    'cp'         => 'required|min_length[5]|max_length[5]',
                ])) {
                    $adsModel->update($idannonce, [
                        'A_titre'            => $this->request->getPost('title'),
                        'A_cout_loyer'       => $this->request->getPost('loyer'),
                        'A_cout_charges'     => $this->request->getPost('charges'),
                        'A_type_chauffage'   => $this->request->getPost('chauffage'),
                        'A_superficie'       => $this->request->getPost('superficie'),
                        'A_description'      => $this->request->getPost('description'),
                        'A_adresse'          => $this->request->getPost('adresse'),
                        'A_ville'            => $this->request->getPost('ville'),
                        'A_CP'               => $this->request->getPost('cp'),
                        'E_idenergie'        => $this->request->getPost('energie'),
                        'T_type'             => $this->request->getPost('type'),
                    ]);

                    $photoModel->save([
                        'P_titre'            => $this->request->getPost('titrePhoto'),
                        'P_data'             => $this->request->getPost('photo'),
                        'A_idannonce'        => $idannonce,
                    ]);

                    return redirect()->to('privateAds');
                } else {
                    // Si l'utilisateur est connecté
                    if (!empty($session->isloggedIn)) {
                        // Récupération du  mail de l'utilisateur
                        $data['iduser'] = $session->umail;
                        $data['pseudo'] = $session->upseudo;
                    } else {

                        $data['iduser'] = null;
                        $data['pseudo'] = null;
                    }
                    echo view('templates/header',  $data);
                    echo view('ads/updateAds', $data);
                    echo view('templates/footer', $data);
                }
        }
    }




}
