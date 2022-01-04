<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'T_message';
    protected $primaryKey = 'P_idphoto';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['M_dateheure_message', 'M_texte_message', 'U_mail', 'A_idannonce'];

    /**
     * Récup_re un message en Base de donnée
     *
     * @param [type] $idUser
     * @param [type] $idAnnonce
     * @return response
     */
    public function getMessage($idUser = null, $idAnnonce = null)
    {
        if ($idUser === null) {
            if ($idAnnonce === null) {
                return $this->findAll();
            }
            else{
                return $this
            ->where(['A_idannonce' => $idAnnonce])
            ->orderBy('M_dateheure_message', 'DESC')
            ->findAll();
            }
        }

        return $this
            ->where(['U_mail' => $idUser, 'A_idannonce' => $idAnnonce])
            ->orderBy('M_dateheure_message', 'DESC')
            ->findAll();
    }

    /**
     * Calcul le nombre de messages pour une annonce
     *
     * @param [type] $idAnnonce
     * @return void
     */
    public function getNumberMessage($idAnnonce = null)
    {
        // Retourne le nombre total de message
        if (($idAnnonce === null)) {
            return $this->countAllResults();
        }

        // le nombre de message pour une annonce en particulier
        return $this
            ->where(['A_idannonce' => $idAnnonce])
            ->countAllResults();
    }
}