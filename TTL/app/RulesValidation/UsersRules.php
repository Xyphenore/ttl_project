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
    public function isValidLoggin($str, $field, $userData)
    {
        $userModel = model(UsersModel::class);
        $user = $userModel->where('email', $userData['email'])
            ->first();

        if (!$user)
            return false;

        return password_verify($userData['pass'], $user['pass']);
    }

}
