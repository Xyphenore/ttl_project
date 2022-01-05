<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'T_utilisateur';
    protected $primaryKey = 'U_mail';
    protected $useAutoIncrement = false;

    protected $allowedFields = ['U_mail', 'U_mdp', 'U_pseudo', 'U_nom', 'U_prenom', 'U_bloc'];


    /**
     * récupère les informations d'un ou plusieurs utilisateur dans la base de données
     *
     * @param boolean $pseudo
     * @return array
     */
    public function getUser($pseudo = false)
    {
        if ($pseudo === false) {
            return $this->where(['U_admin' => false])->findAll();
        }

        return $this->where(['U_pseudo' => $pseudo])->first();
    }



        /**
     * récupère les informations d'un ou plusieurs utilisateur dans la base de données
     *
     * @param  $pseudo
     * @return string
     */
    public function getPseudo($userId)
    {
        return $this->where(['U_mail' => $userId])->findColumn('U_pseudo');
    }

    /**
     * récupère les informations du propriétaire d'une annonce
     *
     * @param  $mail
     * @return array
     */
    public function getAdsOwner($mail)
    {
        return $this->where(['U_mail' => $mail])->first();
    }

}
