<?php

namespace App\Validation;

use  Myth\Auth\Models\UserModel;

class WargaRules
{

    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $users = $model->where('email', $data['email'])
            ->first();

        if (!$users)
            return false;

        return password_verify($data['password'], $users['password']);
    }
}
