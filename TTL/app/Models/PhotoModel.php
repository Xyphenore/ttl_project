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
     * @param boolean $idPhoto
     * @param integer $lim le nombre max de photo à récupérer, 0 = pas de limite
     * @return response le résultat de la requete
     */
    public function getPhoto($idPhoto = false, $lim = 0)
    {
        if ($idPhoto === false) {
            // Toutes les photo à hauteur de la limite indiquée
            return $this
                ->findAll($lim);
        }

        // Une photo en particuler d'après son id
        return $this
            ->where(['P_idphoto' => $idPhoto])
            ->first();
    }

    /**
     * récupère les photos d'une annonce
     *
     * @param [type] $idAnnonce
     * @param boolean $vitrine Si c'est la photo de couverture ou non
     * @return response le résultat de la requete
     */
    public function getAdsPhoto($idAnnonce, $vitrine = false, $lim = 5)
    {
        if ($vitrine === false) {
            // Toutes les photos d'une annonce (max 5)
            return $this
                ->where(['A_idannonce' => $idAnnonce])
                ->findAll($lim);
        }

        // La photo principale
        return $this
            ->where(['A_idannonce' => $idAnnonce, 'P_vitrine' => 1])
            ->first();
    }
}
