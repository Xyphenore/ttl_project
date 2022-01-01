<?php

namespace App\Models;

use CodeIgniter\Model;

class PhotoModel extends Model
{
    protected $table = 'T_photo';
    protected $primaryKey = 'P_idphoto';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['P_titre', 'P_data', 'A_idannonce'];

    /**
     * récupère les informations d'une ou plusieurs photo dans la base de données
     *
     */
    public function getPhoto($idPhoto = false)
    {
        if ($idPhoto === false) {
            return $this->findAll();
        }

        return $this->where(['P_idphoto' => $idPhoto])->first();
    }

    /**
     * récupère les photos d'une annonce
     *
     */
    public function getAdsPhoto($idAnnonce)
    {
        return $this->where(['A_idannonce' => $idAnnonce])->findAll();
    }
}

