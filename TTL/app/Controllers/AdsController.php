<?php

namespace App\Controllers;

use App\Models\AdsModel;
use App\Models\PhotoModel;

class AdsController extends BaseController
{
    public function index()
    {
        $adsModel = model(AdsModel::class);

        $data = [
            'ads'  => $adsModel->getAds(),
            'title' => 'Annonce publiées',
        ];

        echo view('templates/header', $data);
        echo view('ads/allAds', $data);
        echo view('templates/footer', $data);
    }

    public function privateView($idUser)
    {
        $adsModel = model(AdsModel::class);

        $data = [
            'ads'  => $adsModel->getUserAds($idUser),
            'title' => 'Toutes vos annonces',
        ];

        echo view('templates/header', $data);
        echo view('ads/allAds', $data);
        echo view('templates/footer', $data);
    }

    public function view($idAnnonce = null)
    {
        $adsModel = model(AdsModel::class);
        $photoModel = model(PhotoModel::class);

        $data['ads'] = $adsModel->getAds($idAnnonce);

        if (empty($data['ads'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Impossible de trouver l\'annonce: ' . $idAnnonce);
        }

        $data['title'] = $data['ads']['A_titre'];


        // récupération des photos rattachées à l'annonce
        $data['photo'] = $photoModel->getAdsPhoto($data['ads']['A_idannonce']);

        echo view('templates/header', $data);
        echo view('ads/view', $data);
        echo view('templates/footer', $data);
    }

    public function create()
    {
        $adsModel = model(AdsModel::class);

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
                'U_mail'             => "goi.suzy@gmail.com", // TODO à récupérer depuis la session
            ]);

            $iduser = "goi.suzy@gmail.com";


            $this->privateView($iduser);
        } else {
            echo view('templates/header', ['title' => 'création d\'une annonce']);
            echo view('ads/create');
            echo view('templates/footer');
        }
    }

    /**
     * Fonction d'action sur une annonce
     * Change l'état de l'annonce
     */
    public function actionAd()
    {
        $adsModel = model(AdsModel::class);


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
                    $adsModel->update($idAnnonce, ['A_etat' => "En cours de rédaction"]);
                    break;
                case 'Modifier';
                    echo view('templates/header', ['title' => 'Mise à jour d\'une annonce']);
                    echo view('ads/updateAd', $data);
                    break;
                default:
                    $adsModel->update($idAnnonce, ['A_etat' => "En cours de rédaction"]);
                    break;
            }
        }
        // Actualisation de la page
        $this->view($idAnnonce);
    }

    /**
     * Modification d'une annonce
     *
     * @return void
     */
    public function updateAd()
    {
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

            $this->view($idAnnonce);
        } else {
            echo view('templates/header', ['title' => 'création d\'une annonce']);
            echo view('ads/update');
            echo view('templates/footer');
        }
    }
}
