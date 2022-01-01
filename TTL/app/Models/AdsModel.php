<?php

namespace App\Models;

use CodeIgniter\Model;

class AdsModel extends Model
{
    protected $table = 'T_annonce';
    protected $primaryKey = 'A_idannonce';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['A_titre', 'A_cout_loyer', 'A_cout_charges',
    'A_type_chauffage','A_superficie','A_description','A_etat',
    'A_adresse','A_ville','A_CP','E_idenergie','T_type','U_mail'];

    /**
     * récupère les informations d'une ou plusieurs annonces dans la base de données
     *
     */
    public function getAds($idAnnonce = false)
    {
        if ($idAnnonce === false) {
            return $this->findAll();
        }

        return $this->where(['A_idannonce' => $idAnnonce])->first();
    }

    /**
     * récupère les informations d'une ou plusieurs annonces dans la base de données
     *
     */
    public function getUserAds($idUser)
    {
        return $this->where(['U_mail' => $idUser])->findAll();
    }
}

