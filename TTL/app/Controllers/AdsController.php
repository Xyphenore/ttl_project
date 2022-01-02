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

        $data = [
            'ads'  => $adsModel->getAds(null, 0, 0),
            'title' => 'Les dernières annonces publiées',
        ];

        foreach ($data['ads'] as $ads_item){
            // récupération des photos rattachées à chaque annonce
            $ads_item['photo'] = $photoModel->getAdsPhoto($ads_item['A_idannonce'], true);
            // récupération du propriétaire de l'annonce
            $ads_item['owner'] = $usersModel->getAdsOwner($ads_item['U_mail']);
        }

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        }

        

        echo view('templates/header', ['title' => 'Accueil']);
        echo view('templates/debugsession',$data);
        echo view('ads/index', $data);
        echo view('templates/footer', $data);
    }

    public function globalView()
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);

        $usersModel = model(UsersModel::class);

        $data = [
            'ads'  => $adsModel->getAds(null,0,0, "Publiée"),
            'title' => 'Toutes les annonces publiées',
        ];

        foreach ($data['ads'] as $ads_item){
            // récupération des photos rattachées à chaque annonce
            $data['photo'] = $photoModel->getAdsPhoto($ads_item['A_idannonce'], true);
            // récupération du propriétaire de l'annonce
            $data['owner'] = $usersModel->getAdsOwner($ads_item['U_mail']);
        }

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        }


        echo view('templates/header', ['title' => 'Annonces en ligne']);
        echo view('templates/debugsession',$data);
        echo view('ads/allAds', $data);
        echo view('templates/footer', $data);
    }


    public function detailView($idAnnonce = null)
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);
        $usersModel = model(UsersModel::class);

        $data['ads'] = $adsModel->getAds($idAnnonce);

        if (empty($data['ads'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Impossible de trouver l\'annonce: ' . $idAnnonce);
        }

        $data['title'] = $data['ads']['A_titre'];


        // récupération des photos rattachées à l'annonce
        $data['photo'] = $photoModel->getAdsPhoto($data['ads']['A_idannonce']);

        // récupération du propriétaire de l'annonce
        $data['owner']  = $usersModel->getAdsOwner($data['ads']['U_mail']);

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        }


        echo view('templates/header', ['title' => 'Détail de l\'annonce']);
        echo view('templates/debugsession',$data);
        echo view('ads/detailAds', $data);
        echo view('templates/footer', $data);
    }


    public function privateView($idUser)
    {
        $adsModel = model(AdsModel::class);

        $data = [
            'ads'  => $adsModel->getUserAds($idUser),
            'title' => 'Toutes vos annonces',
        ];

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {
            return redirect()->to('forms/loggin');
        }


        echo view('templates/header', ['title' => 'Vos annonces']);
        echo view('templates/debugsession',$data);
        echo view('ads/allAds', $data);
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

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {
            return redirect()->to('forms/loggin');
        }

        // Sauvegarde des champs saisis
        $data['ads'] = [
            'title'         => $this->request->getPost('title'),
            'loyer'         => $this->request->getPost('loyer'),
            'charge'        => $this->request->getPost('charges'),
            'chauffage'     => $this->request->getPost('chauffage'),
            'superficie'    => $this->request->getPost('superficie'),
            'description'   => $this->request->getPost('description'),
            'adresse'       => $this->request->getPost('adresse'),
            'ville'         => $this->request->getPost('ville'),
            'cp'            => $this->request->getPost('cp'),
            'energie'       => $this->request->getPost('energie'),
            'type'          => $this->request->getPost('type'),
        ];

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
            $adsModel->save([
                'A_titre'            => 'title',
                'A_cout_loyer'       => 'loyer',
                'A_cout_charges'     => 'charges',
                'A_type_chauffage'   => 'chauffage',
                'A_superficie'       => 'superficie',
                'A_description'      => 'description',
                'A_adresse'          => 'adresse',
                'A_ville'            => 'ville',
                'A_CP'               => 'cp',
                'E_idenergie'        => 'energie',
                'T_type'             => 'type',
                'U_mail'             => $data['iduser'],
            ]);

            //  redirige vers
            $this->privateView($data['iduser']);
        } else {
            echo view('templates/header', ['title' => 'création d\'une annonce']);
            echo view('templates/debugsession',$data);
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

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {
            return redirect()->to('forms/loggin');
        }

        // Récupération de l'id depuis le formulaire
        $idAnnonce = $this->request->getPost('id');
        $data['ads'] = $adsModel->getAds($idAnnonce);
        $action = $this->request->getPost('act');

        // Mise à jour de l'état de l'annonce en BDD
        if ($this->request->getMethod() === 'post') {

            switch ($action) {
                case 'Publier';
                    $adsModel->update($idAnnonce, ['A_etat' => "Publiée"]);
                    break;
                case 'Supprimer';
                    $adsModel->delete($idAnnonce);
                    $this->index();
                    break;
                case 'Archiver';
                    $adsModel->update($idAnnonce, ['A_etat' => "Archivée"]);
                    break;
                case 'Brouillon';
                    $adsModel->update($idAnnonce, ['A_etat' => "Brouillon"]);
                    break;
                case 'Modifier';
                    echo view('templates/header', ['title' => 'Mise à jour d\'une annonce'], $data);
                    echo view('templates/debugsession',$data);
                    echo view('ads/updateAds', $data);
                    break;
                default:
                    $adsModel->update($idAnnonce, ['A_etat' => "Brouillon"]);
                    break;
            }
        }
        // Actualisation de la page
        $this->detailView($idAnnonce);
    }

    /**
     * Modification d'une annonce
     *
     * @return void
     */
    public function updateAds()
    {
        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        } else {
            return redirect()->to('forms/loggin');
        }

        $adsModel = model(AdsModel::class);
        $idAnnonce = $this->request->getPost('id');

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
            $adsModel->update($idAnnonce, [
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
                'A_idannonce'        => $idAnnonce,
            ]);

            $this->detailView($idAnnonce);
        } else {
            echo view('templates/header', ['title' => 'Edition d\'une annonce']);
            echo view('templates/debugsession',$data);
            echo view('ads/updateAds',$data);
            echo view('templates/footer',$data);
        }
    }
}
