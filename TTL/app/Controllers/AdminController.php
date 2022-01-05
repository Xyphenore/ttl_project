<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AdsModel;
use App\Models\MessageModel;
use App\Models\PhotoModel;



class AdminController extends BaseController
{



    // Partie pour la gestion de l'administrateur

    public function adminDashboard()
    {
        // Chargement des assistances pour le formulaire et les redirections
        helper(['form', 'url']);

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est pas admin
        if (!($session->isAdmin)) {
            return redirect()->to('index');
        }

        $usersModel = model(UsersModel::class);


        $data['tete'] = 'Administration';
        $data['title'] = 'Adminsitration';

        // Affichage de la page avec les champs remplis avec les informations du compte actuel
        echo view('templates/header', $data);
        echo view('admin/adminDashboard', $data);
        echo view('templates/footer', $data);
    }

    /**
     * Pour la gestion des utilisateurs
     *
     * @return void
     */
    public function adminUserManager()
    {
        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est pas admin
        if (!($session->isAdmin)) {
            return redirect()->to('privateAds');
        }


        $usersModel = model(UsersModel::class);
        $messageModel = model(MessageModel::class);
        $adsModel = model(AdsModel::class);

        // récupère tous les utilisateurs inscrit sauf l'admin
        $tmp['user'] = $usersModel->getUser();


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
        echo view('admin/adminUserManager', $data);
        echo view('templates/footer', $data);
    }




    /**
     * Switch la valeur du bouton cliqué et agit en conséquence
     *
     * @return void
     */
    public function adminUserAction()
    {
        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est pas admin
        if (!($session->isAdmin)) {
            return redirect()->to('privateAds');
        }

        $userModel = model(UsersModel::class);
        $adsModel = model(AdsModel::class);


        // Récupération de la valeur du bouton qui a été cliqué
        $action = $this->request->getPost('adminAct');

        // Récupération de l'idUser
        $idUser = $this->request->getPost('idUser');
        // Récupération du pseudo de l'user
        $pseudoUser = $this->request->getPost('pseudoUser');

        // Mise à jour de l'état de l'annonce en BDD
        if ($this->request->getMethod() === 'post') {
            switch ($action) {
                case 'delUser';
                    $userModel->delete($idUser);
                    return redirect()->to('adminUserManager');

                case 'mailUser';
                    // TODO mailUser
                    break;

                case 'editUser';
                    // TODO editUser
                    break;

                case 'blocUser';
                    $userModel->update($idUser, ['U_bloc' => true]);

                    $data['ads'] = $adsModel->getUserAds($idUser);
                    foreach ($data['ads'] as $elem) {
                        // bloque toutes les annonces
                        $adsModel->update($elem['A_idannonce'], ['A_etat' => 'Bloc']);
                    }
                    return redirect()->to('adminUserManager');

                case 'unblocUser';
                    $userModel->update($idUser, ['U_bloc' => false]);

                    $data['ads'] = $adsModel->getUserAds($idUser);
                    foreach ($data['ads'] as $elem) {
                        // débloque toutes les annonces
                        $adsModel->update($elem['A_idannonce'], ['A_etat' => 'Brouillon']);
                    }
                    return redirect()->to('adminUserManager');

                default:
            }
        }
    }
/**
     * Switch la valeur du bouton cliqué et redirige l'utilisateur de manière adequate
     *
     * @return void
     */
    public function actionAdminDashboard()
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
                    return redirect()->to('adminAdsManager');

                case 'Utilisateurs';
                    return redirect()->to('adminUserManager');

                case 'Paramètre';
                    return redirect()->to('UserSetting');

                default:
                    return redirect()->to('dashboard');
            }
        }
    }

    /**
     * Switch la valeur du bouton cliqué et agit en conséquence
     *
     * @return void
     */
    public function adminAdAction()
    {
        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est pas admin
        if (!($session->isAdmin)) {
            return redirect()->to('index');
        }

        $userModel = model(UsersModel::class);
        $adsModel = model(AdsModel::class);

        // Récupération de la valeur du bouton qui a été cliqué
        $action = $this->request->getPost('adminAct');

        // Récupération de l'idUser
        $idUser = $this->request->getPost('idUser');
        // Récupération de l'idAnnonce
        $idAnnonce = $this->request->getPost('idAd');

        // Mise à jour de l'état de l'annonce en BDD
        if ($this->request->getMethod() === 'post') {
            switch ($action) {
                case 'delAd';
                    $adsModel->delete($idAnnonce);
                    return redirect()->to('adminAdsManager');

                case 'editAd';


                case 'blocAd';
                    $adsModel->update($idAnnonce, ['A_etat' => 'Bloc']);
                    return redirect()->to('adminAdsManager');

                case 'unblocAd';
                    $adsModel->update($idAnnonce, ['A_etat' => 'Brouillon']);
                    return redirect()->to('adminAdsManager');


                default:
            }
        }
    }

        /**
     * Switch la valeur du bouton cliqué et agit en conséquence
     *
     * @return void
     */
    public function debug()
    {
       
        $adsModel = model(AdsModel::class);
        $adsModel->update(null, ['A_etat' => 'Public']);
        return redirect()->to('index');
    }



    public function adminAdsManager()
    {
       // On récupère la session actuelle
       $session = session();

       // Si l'utilisateur est pas admin
       if (!($session->isAdmin)) {
           return redirect()->to('index');
       }

        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);

        $usersModel = model(UsersModel::class);

        $data = [
            'ads'   => $adsModel->getAds(null, 0, 0, 'Public'),
            'title' => 'administration',
            'tete' => 'administration',
        ];

            echo view('templates/header', $data);
            echo view('admin/adminAdsManager', $data);
            echo view('templates/footer', $data);
    }
}
