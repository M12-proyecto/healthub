<?php

namespace App\Policies;

use App\Models\User;

class ResultadoPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create() {
        $userRole = User::getRole();
        $allowedRoles = ['Administrador','Medico'];

        return in_array($userRole, $allowedRoles);
    }

    public function read() {
        
    }

    public function update() {
        $userRole = User::getRole();
        $allowedRoles = ['Administrador', 'Medico'];

        return in_array($userRole, $allowedRoles);
    }

    public function delete() {
        $userRole = User::getRole();
        $allowedRoles = ['Administrador', 'Medico'];

        return in_array($userRole, $allowedRoles);
    }
}
