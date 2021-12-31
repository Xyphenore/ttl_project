<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'T_utilisateur';
    protected $primaryKey = 'U_mail';
    protected $useAutoIncrement = false;

    protected $allowedFields = ['U_mail', 'U_mdp', 'U_pseudo', 'U_nom', 'U_prenom'];


    /**
     * récupère les informations d'un ou plusieurs utilisateur dans la base de données
     *
     * @param boolean $pseudo
     * @return array
     */
    public function getUser($pseudo = false)
    {
        if ($pseudo === false) {
            return $this->findAll();
        }

        return $this->where(['U_pseudo' => $pseudo])->first();
    }


}
