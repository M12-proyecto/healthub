<?php

namespace App\Policies;

use App\Models\User;

class InformePolicy
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
        $allowedRoles = ['Administrador', 'Medico'];

        return in_array($userRole, $allowedRoles);
    }

    public function read() {
        $userRole = User::getRole();
        $allowedRoles = ['Administrador', 'Medico', 'Recepcionista', 'Paciente'];

        return in_array($userRole, $allowedRoles);
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
