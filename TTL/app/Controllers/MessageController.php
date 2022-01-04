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
        // $test = $messageModel->getMessage();
        // var_dump($test);
        // récupération des annonces de l'utilisateur
        $tmp['ads'] = $adsModel->getUserAds($session->umail);
        $tmp2 = [];
        foreach ($tmp['ads'] as $k => $v) {
            if (!empty($messageModel->getMessage(null, $v['A_idannonce']))){
                // $message[] = $messageModel->getMessage(null, $v['A_idannonce']);
            // var_dump($message);
            // Stockage du tableau dans un tableau
                // $tmp2[] = $message;
                $tmp2[] =$messageModel->getMessage(null, $v['A_idannonce']);
            }
        }
        // var_dump($message);
        // var_dump($tmp2);
        // // Récupération des messages rattaché à une annonce
        // $tmp['message'] = $messageModel->getMessage();
        // $tmp2 = [];
        // // TODO faire plutôt des jointures en BDD
        // foreach ($tmp['message'] as $k => $v) {
        //     $peudo['pseudo'] = $usersModel->getPseudo($v['U_mail']);
        //     $tmp2[] = array_merge($v, $peudo);
        // }

        $data['title'] = 'Messages';
        $data['tete'] = 'Vos messages';
        $data['messages'] = $tmp2;

        var_dump($data['messages']);

        echo view('templates/header', $data);
        echo view('messages/allMessages', $data);
        echo view('templates/footer', $data);
    }

    /**
     * Sauvegarde un message en base de donnée
     *
     */
    public function contacter()
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
                'U_mail'             => $this->request->getPost($session->umail),
                'A_idannonce'        => $this->request->getPost('idAnnonce'),
            ]);
        }

        echo view('templates/header', $data);
        echo view('ads/detailAds', $data);
        echo view('templates/footer', $data);
    }
}
