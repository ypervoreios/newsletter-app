<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MailSetting;

class SettingsController extends Controller
{
    public function mail()
    {
        $settings = MailSetting::first();

        return view('settings.mail', compact('settings'));
    }

    public function mailUpdate(Request $request)
    {
        $data = $request->validate([
            'host' => 'nullable|string',
            'port' => 'nullable|numeric',
            'username' => 'nullable|string',
            'password' => 'nullable|string',
            'encryption' => 'nullable|string',
            'from_address' => 'nullable|email',
            'from_name' => 'nullable|string',
        ]);

        $settings = MailSetting::first();

        if (!$settings) {
            MailSetting::create($data);
        } else {
            $settings->update($data);
        }

        return redirect()->route('settings.mail')
            ->with('success', 'Mail settings updated.');
    }
}
