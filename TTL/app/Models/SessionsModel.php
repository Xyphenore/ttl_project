<?php

namespace App\Models;

use CodeIgniter\Model;

class SessionsModel extends Model
{
    protected $table = 'T_session';
    protected $primaryKey = 'S_idsession';
    protected $useAutoIncrement = false;

    protected $allowedFields = ['S_idsession', 'S_ipaddress', 'S_timestamp', 'S_data'];

  
    /**
     * récupère les informations d'une ou plusieurs sessions dans la base de données
     *
     * @param boolean $timestamp
     * @return array
     */
    public function getSession($timestamp = false)
    {
        if ($timestamp === false) {
            return $this->findAll();
        }

        return $this->where(['S_timestamp' => $timestamp])->first();
    }
}