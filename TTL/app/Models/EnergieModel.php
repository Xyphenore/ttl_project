<?php

namespace App\Models;

use CodeIgniter\Model;

class EnergieModel extends Model
{
    protected $table = 'T_energie';
    protected $primaryKey = 'E_idenergie';
    protected $useAutoIncrement = false;

    protected $allowedFields = ['E_idenergie', 'E_description'];

    /**
     * récupère les informations dans la BDD
     *
     */
    public function getEnergie($idenergie = false)
    {
        if ($idenergie === false) {
            return $this->findAll();
        }

        return $this->where(['E_idenergie' => $idenergie])->first();
    }
}

