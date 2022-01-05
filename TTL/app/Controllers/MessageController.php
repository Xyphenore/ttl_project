<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AdsModel;
use App\Models\MessageModel;

class MessageController extends BaseController
{

    /**
     * Ouvre le contenu d'un message et passe son état à lu
     *
     * @param [type] $idMessage
     * @return void
     */
    public function view($idMessage = null)
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);
        $usersModel = model(UsersModel::class);
        $messageModel = model(MessagesModel::class);

        $data['msg'] = $adsModel->getAds($idMessage);
        $data['title'] = 'Détail du message';

        if (empty($data['msg'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Impossible de trouver le message ' . $idMessage);
        }

        $messageModel->update($idMessage, ['M_lu' => true]);

        // récupération de la photo vitrine rattachées à l'annonce
        $data['vitrine'] = $photoModel->getAdsPhoto($data['msg']['A_idannonce'], true);
        // récupération des 4 autres photos éventuelles rattachées à l'annonce
        $data['photos'] = $photoModel->getAdsPhoto($data['msg']['A_idannonce'], false);
        // récupération du pseudo de l'utilisateur qui a envoyé le message
        $data['sentby']  =  $usersModel->getUser($usersModel->getAdsOwner($data['msg']['U_mail']));

        $data['tete'] = $data['msg']['sentby'];

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
        echo view('messages/msg', $data);
        echo view('templates/footer', $data);
    
    }







    public function viewMessages()
    {
        $usersModel = model(UsersModel::class);
        $messageModel = model(MessageModel::class);
        $adsModel = model(adsModel::class);
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

        $data['title'] = 'Messages';
        $data['tete'] = 'Vos messages';

        // On vérifie si l'utilisateur a des annonces
        if (!empty($adsModel->getUserAds($session->umail))) {
            // récupération des annonces de l'utilisateur
            $tmp['ads'] = $adsModel->getUserAds($session->umail);
            $tmp2 = [];

            foreach ($tmp['ads'] as $k => $v) {
                // on récupère les messages concernant cette annonce
                if (!empty($messageModel->getMessage(null, $v['A_idannonce']))) {
                    $tmp2[] = $messageModel->getMessage(null, $v['A_idannonce']);
                }
            }
            $tmp3['msg'] = $tmp2;

            $tmp4 = [];
            // pour chaque message concernant cette annonce
            foreach ($tmp3['msg'] as $key => $value) {
                foreach ($value as $k => $v) {
                    // on récupère le pseudo de l'utilisateur qui a initié la discussion
                    if (!empty($usersModel->getPseudo($v['U_mail']))) {
                        $pseudo = $usersModel->getPseudo($v['U_mail']);
                        // on fusionne (TODO, faire jointure en BDD directement)
                        $tmp4[] = array_merge($v, $pseudo);
                    }
                }
            }
            $data['messages'] = $tmp4;

            echo view('templates/header', $data);
            echo view('messages/messages', $data);
            echo view('templates/footer', $data);
            
        } else 
        
        // TODO à revoir dans une amélioration de la messagerie (fil de discussion)
        {
            $tmp['msg'] = $messageModel->getMessage($session->umail, null);
            $tmp2 = [];
            // pour chaque message concernant cet utilisateur
            foreach ($tmp['msg'] as $key => $value) {
                // On récupère les annonces concernée par les messages de cet utilisateurs
                if (!empty($messageModel->getMessage(null, $value['A_idannonce']))) {
                    $tmp2[] = $messageModel->getMessage(null, $value['A_idannonce']);
                }
            }
            $tmp3['ads'] = $tmp2;

            $tmp4 = [];
            // pour chaque annonce concernée
            foreach ($tmp3['ads'] as $key => $value) {
                foreach ($value as $k => $v) {
                    // on récupère le pseudo du propriétaire
                    if (!empty($usersModel->getPseudo($v['U_mail']))) {
                        $pseudo = $usersModel->getPseudo($v['U_mail']);
                        // on fusionne (TODO, faire jointure en BDD directement)
                        $tmp4[] = array_merge($v, $pseudo);
                    }
                }
            }
            $data['messages'] = $tmp4;

            echo view('templates/header', $data);
            echo view('messages/messages', $data);
            echo view('templates/footer', $data);
        }
    }


    /**
     * Sauvegarde un message en base de donnée
     *
     */
    public function contact()
    {
        $messageModel = model(MessageModel::class);
        $data['tete'] = 'création d\'un message';
        $data['title'] = 'Nouveau message';

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

        if ($this->request->getMethod() === 'post' && $this->validate([
            'message'      => 'required',
        ])) {
            if (!empty($session->isloggedIn)) {

                $messageModel->save([
                    'M_texte_message'    => $this->request->getPost('message'),
                    'U_mail'             => $session->umail,
                    'A_idannonce'        => $this->request->getPost('idAnnonce'),
                ]);
            } else {
                return redirect()->to('login');
            }
        }
        return redirect()->to('messages');
    }

    public function actionMessage()
    {
        $messageModel = model(MessageModel::class);
        $data['tete'] = 'Action sur annonce';
        $data['title'] = 'Action';

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isloggedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        }

        // Récupération de l'id depuis le formulaire
        // $idAnnonce = $this->request->getPost('idAnnonce');
        // $idUserMsgFrom = $this->request->getPost('idUser');
        $idMessage = $this->request->getPost('idmsg');


        $action = $this->request->getPost('act');

        // Mise à jour de l'état de l'annonce en BDD
        if ($this->request->getMethod() === 'post') {

            switch ($action) {
                case 'Lire';
                    $messageModel->update($idMessage, ['M_lu' => true]);
                    return redirect()->to('messages');
                case 'Repondre';
                    if (!empty($session->isloggedIn)) {

                        $messageModel->save([
                            'M_texte_message'    => $this->request->getPost('message'),
                            'U_mail'             => $session->umail,
                            'A_idannonce'        => $this->request->getPost('idAnnonce'),
                        ]);
                    }
                    return redirect()->to('messages');
                default:
                    return redirect()->to('dashboard');
            }
        }
    }
}
