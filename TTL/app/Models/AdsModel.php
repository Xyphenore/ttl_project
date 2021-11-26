<?php

namespace App\Models;

use CodeIgniter\Model;

class AdsModel extends Model
{
    protected $table = 'T_annonce';

    protected $allowedFields = ['A_idannonce','A_title', 'A_cout_loyer', 'A_cout_charges',
    'A_date_creation','A_date_modification','A_type_chauffage','A_superficie','A_description',
    'A_adresse','A_ville','A_CP','A_etat','slug','E_idengie','T_type','U_mail'];

    public function getAds($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

