<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function view(User $user, Employee $employee): bool { return $user->is($employee->user); }
    public function update(User $user, Employee $employee): bool { return $user->is($employee->user); }
    public function delete(User $user, Employee $employee): bool { return $user->is($employee->user); }
}
