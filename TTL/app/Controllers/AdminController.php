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

        $session = session();

        // Impossible d'accéder à la page pour un utilisateur non admin
        if (!($session->isAdmin)) {
            return redirect()->to('/');
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
        $userModel = model(UsersModel::class);
        $adsModel = model(AdsModel::class);

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur n'est pas connecté
        if (empty($session->isloggedIn)) {
            return redirect()->to('login');
        }

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
                    return redirect()->to('users/' . $pseudoUser);

                case 'unblocUser';
                    $userModel->update($idUser, ['U_bloc' => false]);

                    $data['ads'] = $adsModel->getUserAds($idUser);
                    foreach ($data['ads'] as $elem) {
                        // débloque toutes les annonces
                        $adsModel->update($elem['A_idannonce'], ['A_etat' => 'Brouillon']);
                    }
                    return redirect()->to('users/' . $pseudoUser);

                default:
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
        $userModel = model(UsersModel::class);
        $adsModel = model(AdsModel::class);

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur n'est pas connecté
        if (empty($session->isloggedIn)) {
            return redirect()->to('login');
        }

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




    public function adminAdsManager()
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
        echo view('admin/adminAdsManager', $data);
        echo view('templates/footer', $data);
    }
}
