<?php

namespace App\Controllers;

use App\Models\PhotoModel;


class PhotoController extends BaseController
{
    public function index()
    {
        $photoModel = model(PhotoModel::class);

        $data = [
            'photo'  => $photoModel->getPhoto(),
            'title' => 'Photos publiées',
        ];

        echo view('templates/header', $data);
        echo view('photos/allPhotos', $data);
        echo view('templates/footer', $data);
    }

    public function privateView($idAnnonce)
    {
        $photoModel = model(PhotoModel::class);

        $data = [
            'photo'  => $photoModel->getAdsPhoto($idAnnonce),
            'title' => 'Toutes vos photos',
        ];

        echo view('templates/header', $data);
        echo view('photos/allPhotos', $data);
        echo view('templates/footer', $data);
    }

    public function view($idPhoto = null)
    {
        $photoModel = model(PhotoModel::class);

        $data['photo'] = $photoModel->getPhoto($idPhoto);

        if (empty($data['photo'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Impossible de trouver la photo: ' . $idPhoto);
        }

        $data['title'] = $data['photo']['P_titre'];

        echo view('templates/header', $data);
        echo view('photos/photoView', $data);
        echo view('templates/footer', $data);
    }
}
