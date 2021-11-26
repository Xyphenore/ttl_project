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
            'title' => 'Ads archive',
        ];

        echo view('templates/header', $data);
        echo view('ads/overview', $data);
        echo view('templates/footer', $data);
    }

    public function view($slug = null)
    {
        $model = model(AdsModel::class);

        $data['ads'] = $model->getAds($slug);

        if (empty($data['ads'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the ads item: ' . $slug);
        }

        $data['title'] = $data['ads']['title'];

        echo view('templates/header', $data);
        echo view('ads/view', $data);
        echo view('templates/footer', $data);
    }

    public function create()
    {
        $model = model(AdsModel::class);

        if ($this->request->getMethod() === 'post' && $this->validate([
            'title' => 'required|min_length[3]|max_length[255]',
            'body'  => 'required',
        ])) {
            $model->save([
                'title' => $this->request->getPost('title'),
                'slug'  => url_title($this->request->getPost('title'), '-', true),
                'body'  => $this->request->getPost('body'),
            ]);

            echo view('ads/success');
        } else {
            echo view('templates/header', ['title' => 'Create a ads item']);
            echo view('ads/create');
            echo view('templates/footer');
        }
    }
}
