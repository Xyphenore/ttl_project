<?php

namespace App\Controllers;

use App\Models\AdsModel;


class AdsController extends BaseController
{
    public function index()
    {
        $model = model(AdsModel::class);

        $data = [
            'ads'  => $model->getAds(),
            'title' => 'Annonce publiées',
        ];

        echo view('templates/header', $data);
        echo view('ads/allAds', $data);
        echo view('templates/footer', $data);
    }

    public function view($idAnnonce = null)
    {
        $adsModel = model(AdsModel::class);

        $data['ads'] = $adsModel->getAds($idAnnonce);

        if (empty($data['ads'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the ads item: ' . $idAnnonce);
        }

        $data['title'] = $data['ads']['A_titre'];

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
                'U_mail'             => "goi.suzy@gmail.com",
            ]);

            echo view('ads/publish',['title' => 'vérification avant publication']);
        } else {
            echo view('templates/header', ['title' => 'création d\'une annonce']);
            echo view('ads/create');
            echo view('templates/footer');
        }
    }

    /**
     * Fonction de validation avant publication d'une annonce
     *
     * @return void
     */
    public function publishAd()
    {
        $adsModel = model(AdsModel::class);

        if ($this->request->getMethod() === 'post') {
            $adsModel->save(['A_etat'    => "Publiée"]);
        } 
            echo view('templates/header', ['title' => 'Liste des annonces']);
            echo view('ads/allAds');
            echo view('templates/footer');
        }
    }

