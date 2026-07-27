<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MailSetting;

class MailSettingsSeeder extends Seeder
{
    public function run()
    {
        MailSetting::firstOrCreate([
            'id' => 1,
        ], [
            'host' => env('MAIL_HOST', ''),
            'port' => env('MAIL_PORT', ''),
            'username' => env('MAIL_USERNAME', ''),
            'password' => env('MAIL_PASSWORD', ''),
            'encryption' => env('MAIL_ENCRYPTION', ''),
            'from_address' => env('MAIL_FROM_ADDRESS', ''),
            'from_name' => env('MAIL_FROM_NAME', ''),
        ]);
    }
}
