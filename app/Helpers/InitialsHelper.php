<?php

namespace App\Helpers;

use App\Models\User;

class InitialsHelper
{
    public static function generateInitials($user)
    {
        $userData = $user;
        if (is_int($user)) {
            $userDetails = User::find($user);
            if (! $userDetails) {
                $userData = 'X';
            }
            $userData = $userDetails->name;
        }

        $initials = implode('', array_map(
            fn($word) => strtoupper($word[0]),
            array_slice(explode(' ', $userData), 0, 2)
        ));

        // Ensure the result is always 2 characters long
        return str_pad($initials, 2, 'X');
    }
}
