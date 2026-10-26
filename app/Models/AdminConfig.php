<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Hash;

class AdminConfig extends Model
{
    protected $fillable = ['key', 'password_hash'];

    public static function getPasswordHash()
    {
        $config = self::firstOrCreate(
            ['key' => 'admin_password'],
            ['password_hash' => Hash::make('admin2026')]
        );
        return $config->password_hash;
    }

    public static function verifyPassword($rawPassword)
    {
        return Hash::check($rawPassword, self::getPasswordHash());
    }

    public static function setPassword($newRawPassword)
    {
        $config = self::firstOrCreate(['key' => 'admin_password']);
        $config->password_hash = Hash::make($newRawPassword);
        $config->save();
    }
}
