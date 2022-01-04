<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\AdsModel;
use App\Models\MessageModel;



class MessageController extends BaseController
{
    public function viewAdsMessages()
    {
        $usersModel = model(UsersModel::class);
        $messageModel = model(MessageModel::class);
        $adsModel = model(adsModel::class);
        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        }

        // récupération des annonces de l'utilisateur
        $tmp['ads'] = $adsModel->getUserAds($session->umail);
        $tmp2 = [];
        foreach ($tmp['ads'] as $k => $v) {
            if (!empty($messageModel->getMessage(null, $v['A_idannonce']))) {
                $tmp2[] = $messageModel->getMessage(null, $v['A_idannonce']);
            }
        }
        $tmp3['msg'] = $tmp2;

        $tmp4 = [];
        foreach ($tmp3['msg'] as $key => $value) {
            foreach ($value as $k => $v) {
                if (!empty($usersModel->getPseudo($v['U_mail']))) {
                    $pseudo = $usersModel->getPseudo($v['U_mail']);
                    $tmp4[] = array_merge($v, $pseudo);
                }
            }
        }

        $data['title'] = 'Messages';
        $data['tete'] = 'Vos messages';
        $data['messages'] = $tmp4;

        echo view('templates/header', $data);
        echo view('messages/allMessages', $data);
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
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        }

        // récupération des messages de l'utilisateur
        $tmp['msg'] = $messageModel->getMessage($session->umail, null);
        $tmp2 = [];
        foreach ($tmp['msg'] as $k => $v) {
            if (!empty($usersModel->getUser($v['U_mail']))) {
                $tmp2[] = array_merge($v, $usersModel->getUser($v['U_mail']));
            }
        }
        
        $data['title'] = 'Messages';
        $data['tete'] = 'Vos messages';
        $data['messages'] = $tmp2;
   
        echo view('templates/header', $data);
        echo view('messages/sentMessages', $data);
        echo view('templates/footer', $data);
    }

    /**
     * Sauvegarde un message en base de donnée
     *
     */
    public function contact()
    {
        $messageModel = model(MessageModel::class);
        $data['tete'] = 'création d\'une annonce';
        $data['title'] = 'Nouvelle annonce';

        // On récupère la session actuelle
        $session = session();

        // Si l'utilisateur est connecté
        if (!empty($session->isLoogedIn)) {
            // Récupération du  mail de l'utilisateur
            $data['iduser'] = $session->umail;
            $data['pseudo'] = $session->upseudo;
        }

        if ($this->request->getMethod() === 'post' && $this->validate([
            'message'      => 'required',
        ])) {

            $messageModel->save([
                'M_texte_message'    => $this->request->getPost('message'),
                'U_mail'             => $session->umail,
                'A_idannonce'        => $this->request->getPost('idAnnonce'),
            ]);
        }

        return redirect()->to('ads/' . $this->request->getPost('idAnnonce'));
    }
}
