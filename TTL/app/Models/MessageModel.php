<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'T_message';
    protected $primaryKey = 'M_idmessage';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['M_idmessage','M_dateheure_message', 'M_texte_message', 'U_mail', 'A_idannonce', 'M_lu'];

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
            ->where(['U_mail' => $idUser])
            ->orderBy('M_dateheure_message', 'DESC')
            ->findAll();
    }

    /**
     * Récup_re un message en Base de donnée
     *
     * @return response
     */
    public function getMessageById($idmessage)
    {
     
        return $this
            ->where(['M_idmessage' => $idmessage])
            ->first();
    }


    // /**
    //  * Calcul le nombre de messages pour une annonce
    //  *
    //  * @param [type] $idAnnonce
    //  * @return void
    //  */
    // public function getNumberMessage($idAnnonce = null)
    // {
    //     // Retourne le nombre total de message
    //     if (($idAnnonce === null)) {
    //         return $this->countAllResults();
    //     }

    //     // le nombre de message pour une annonce en particulier
    //     return $this
    //         ->where(['A_idannonce' => $idAnnonce])
    //         ->countAllResults();
    // }

     /**
     * Calcul le nombre de messages non lu pour une annonce
     *
     * @param [type] $idAnnonce
     * @return void
     */
    public function numberUnreadMessage($idAnnonce)
    {
        // le nombre de message non lu
        return $this
            ->where(['A_idannonce' => $idAnnonce, 'M_lu' => false])
            ->countAllResults();
    }

         /**
     * Calcul le nombre de messages pour une annonce
     *
     * @param [type] $idAnnonce
     * @return void
     */
    public function numberMessage($idAnnonce)
    {
        // le nombre de message non lu
        return $this
            ->where(['A_idannonce' => $idAnnonce])
            ->countAllResults();
    }

    //      /**
    //  * Calcul le nombre de messages non lu pour un utilisateur
    //  *
    //  * @param [type] $idAnnonce
    //  * @return void
    //  */
    // public function UnreadMessage($idUser)
    // {
    //     // le nombre de message non lu
    //     return $this
    //         ->where(['U_mail' => $idUser, 'M_lu' => false])
    //         ->countAllResults();
    // }
}
