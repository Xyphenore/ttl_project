<?php

namespace App\Controllers;

use App\Models\EnergieModel;


class EnergieController extends BaseController
{

    public function getEnergie($idenergie = null)
    {
        $energieModel = model(EnergieModel::class);

        $data['energie'] = $energieModel->getEnergie($idenergie);

        if (empty($data['energie'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the energie item: ' . $idenergie);
        }

        $data['typeEnergie'] = $data['energie']['E_idenergie'];

        return $data;
    }
}

