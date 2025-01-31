<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Survey;

class GenerateTokenHelper
{
    /**
     * Generate a secure random token for surveys.
     *
     * @param int $length Length of the token
     * @return string
     * @throws \Exception
     */
    public function generateSecureToken($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_=+[]{}|;:,.<>?';
        $charactersLength = strlen($characters);
        $randomString = '';
        $model = new Survey();

        do {
            $randomString = '';
            // Generate random string
            for ($i = 0; $i < $length; $i++) {
                $randomByte = random_int(0, $charactersLength - 1);
                $randomString .= $characters[$randomByte];
            }

            // Ensure the token does not already exist in the database
            $exists = $model->where('token', $randomString)->exists();

        } while ($exists);

        return $randomString;
    }

}
