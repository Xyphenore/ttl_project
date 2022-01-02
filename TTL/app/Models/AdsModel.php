<?php

namespace App\Models;

use CodeIgniter\Model;

class AdsModel extends Model
{
    protected $table = 'T_annonce';
    protected $primaryKey = 'A_idannonce';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'A_titre', 'A_cout_loyer', 'A_cout_charges',
        'A_type_chauffage', 'A_superficie', 'A_description', 'A_etat',
        'A_adresse', 'A_ville', 'A_CP', 'E_idenergie', 'T_type', 'U_mail'
    ];

    /**
     * Récupère une ou plusieurs annonces dans la base de données
     *
     * @param integer $idAnnonce
     * @param integer $lim le nombre max d'annonces à récupérer, 0 = pas de limite
     * @param integer $pffset le décalage 0 = pas de décalage
     * @param string $etat Brouillon, Public, Archive ou Bloque
     * @return response le résultat de la requete
     */
    public function getAds($idAnnonce = null, $lim = 0, $offset = 0, $etat = null)
    {
        if ($idAnnonce === null) {
            if ($etat === null) {
                // Toutes les annonces quelque soit leur état de la plus récente à la plus ancienne
                return $this
                    ->orderBy('A_date_creation', 'DESC')
                    ->findAll($lim,$offset);
            } else {
                // Seulement les annonces dans un état en particulier
                return $this
                    ->where(['A_etat' => $etat])
                    ->orderBy('A_date_creation', 'DESC')
                    ->findAll($lim,$offset);
            }
        }

        // Une seule annonce en particulier selon son id
        return $this
            ->where(['A_idannonce' => $idAnnonce])
            ->first();
    }

    /**
     * récupère toutes les annonces d'un utilisateur dans la base de données
     *
     * @param [type] $idUser
     * @param integer $lim le nombre max d'annonces à récupérer, 0 = pas de limite
     * @param integer $pffset le décalage 0 = pas de décalage
     * @param string $etat Brouillon, Publiée, Archivée ou Bloquée
     * @return response le résultat de la requete
     */
    public function getUserAds($idUser, $lim = 0, $offset = 0, $etat = null)
    {
        if (($etat === null)) {
            // toutes les annonces de l'utilisateur quelque soit leur état
            return $this
                ->where(['U_mail' => $idUser])
                ->orderBy('A_date_creation', 'DESC')
                ->findAll($lim,$offset);
        }
        // Uniquement les annonces dans un état précis
        return $this
            ->where(['U_mail' => $idUser, 'A_etat' => $etat])
            ->orderBy('A_date_creation', 'DESC')
            ->findAll($lim,$offset);
    }
}
