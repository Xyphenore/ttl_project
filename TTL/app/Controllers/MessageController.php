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

        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);
        $usersModel = model(UsersModel::class);
        $messageModel = model(MessageModel::class);

        $data['msg'] = $messageModel->getMessageById($idMessage);
        $data['title'] = 'Détail du message';

        if (empty($data['msg'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Impossible de trouver le message ' . $idMessage);
        }

        // var_dump($data['msg']);
        $mail = $data['msg']['U_mail'];
        // Passe l'état du message à lu
        $messageModel->update($idMessage, ['M_lu' => true]);

        // // récupération de la photo vitrine rattachées à l'annonce
        // $data['vitrine'] = $photoModel->getAdsPhoto($data['msg']['A_idannonce'], true);
        // // récupération des 4 autres photos éventuelles rattachées à l'annonce
        // $data['photos'] = $photoModel->getAdsPhoto($data['msg']['A_idannonce'], false);
        // récupération du pseudo de l'utilisateur qui a envoyé le message
        $tmp = $usersModel->getPseudo($mail);
        // var_dump($tmp);
        // echo $tmp[0];
        $data['sentby'] = $tmp[0];
        echo $data['sentby'];

        $data['tete'] = "Message de " . $data['sentby'];


        echo view('templates/header',  $data);
        echo view('messages/msg', $data);
        echo view('templates/footer', $data);
    }


    public function viewMessages()
    {
        $adsModel = model(AdsModel::class);
        $usersModel = model(UsersModel::class);
        $messageModel = model(MessageModel::class);
        $photoModel = model(PhotoModel::class);


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

        // On vérifie si l'utilisateur a des annonces
        if (!empty($adsModel->getUserAds($session->umail))) {
            // Toutes les annonces quel que soit leur état
            $tmp['ads'] = $adsModel->getUserAds($session->umail);

            $tmp2 = [];
            $count = [];

            // fusion des requetes
            // TODO faire cette manip en requete dans la base de données
            // TODO faire un groupBY 
            foreach ($tmp['ads'] as $k => $v) {
                // Récupère le nombre de message non lu
                // $count['unread'] = $messageModel->numberUnreadMessage($v['A_idannonce']);
                $count['nbmessage'] = $messageModel->numberMessage($v['A_idannonce']);
                // récupération du nombre de message non lu
                $unread['unread'] = $this->hasUnreadMessage($v['A_idannonce']);

                // on récupère les messages concernant cette annonce
                if (!empty($messageModel->getMessage(null, $v['A_idannonce']))) {
                    $tmp3['msg'] = $messageModel->getMessage(null, $v['A_idannonce']);

                    $tmp2[] = array_merge($v, $tmp3, $unread,  $count);
                } else {
                    $tmp2[] = array_merge($v, $unread,  $count);
                }
            }
            $data['ads'] = $tmp2;
            $tmp4 = [];
            $sentby = [];
            $tmp5 = [];

            // $listmsg=[];
            // $listAds=[];
            // foreach ($data['ads'] as $key => $value) {
            //     if (!empty($value['msg'])) {
            //         foreach ($value['msg'] as $elem) {
            //             // on récupère le pseudo de l'utilisateur qui a initié la discussion
            //             $tmp4 = $elem;
            //             $tmp4['sentby']=$usersModel->getPseudo($elem['U_mail'])[0];
            //            $listmsg[] = $tmp4;
            //         }
            //     }
            //     $value=['msg'=> $listmsg];
            //     // $listAds[] = array_merge($value['msg'] = $listmsg);
            // }
        }

        //     $data['ads'] = $tmp4;
        // }

        // var_dump($data['ads']);

        $data['tete'] = 'Vos messages';
        $data['title'] = 'vos message';

        echo view('templates/header', $data);
        echo view('messages/adsMessages', $data);
        echo view('templates/footer', $data);
    }

    /**
     * pour la notification si une annonce à des messages non lus
     *
     */
    public function hasUnreadMessage($idAnnonce)
    {
        $messageModel = model(MessageModel::class);


        $count = $messageModel->numberUnreadMessage($idAnnonce);


        $data['hasnewmsg'] = ($count > 0);
        $data['count'] = $count;

        return $data;
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
