<?php

namespace App\RulesValidation;

use App\Models\UsersModel;

class UsersRules
{
    /**
     * Regle personnalisée pour vérifier la concordance mail/mdp
     * Attention, doit être ajouté dans la variable $ruleSets[]
     * du fichier app/Validation/Rulesvalidation.php
     * @param [type] $str
     * @param [type] $field
     * @param [type] $userData
     * @return boolean
     */
    public function isValidlogin($str, $field, $userData)
    {
        $userModel = model(UsersModel::class);
        $user = $userModel->where($userModel->primaryKey, $userData['email'])->first();

        if (!$user)
            return false;

        return $userData['pass'] == $user['U_mdp']; //password_verify($userData['pass'], $user['U_mdp']);
    }


}
