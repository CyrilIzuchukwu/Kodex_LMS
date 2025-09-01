<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TestEmail;
use App\Models\EmailSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ManageEmailController extends Controller
{
    public function config()
    {
        return view('admin.email.config', [
            'title' => 'Email Configuration',
        ]);
    }

    public function update(Request $request)
    {
        // Define common validation rules
        $rules = [
            'provider' => 'required|in:phpmailer,mailjet',
            'status' => 'boolean',
            'from_name' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
        ];

        // Add provider-specific validation rules
        if ($request->input('provider') === 'phpmailer') {
            $rules = array_merge($rules, [
                'host' => 'required|string|max:255',
                'port' => 'required|string|max:5',
                'encryption' => 'nullable|in:tls,ssl',
                'username' => 'required|string|max:255',
                'password' => 'required|string|max:255',
            ]);
        } elseif ($request->input('provider') === 'mailjet') {
            $rules = array_merge($rules, [
                'api_public' => 'required|string|max:255',
                'api_secret' => 'required|string|max:255',
            ]);
        }

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Retrieve or create the email settings record
        $emailSetting = EmailSetting::first() ?? new EmailSetting();

        // Update common fields
        $emailSetting->provider = $request->input('provider');
        $emailSetting->status = $request->boolean('status');
        $emailSetting->from_name = $request->input('from_name');
        $emailSetting->from_email = $request->input('from_email');

        // Update provider-specific fields
        if ($request->input('provider') === 'phpmailer') {
            $emailSetting->host = $request->input('host');
            $emailSetting->port = $request->input('port');
            $emailSetting->encryption = $request->input('encryption');
            $emailSetting->username = $request->input('username');
            $emailSetting->password = $request->input('password');
            $emailSetting->api_public = null; // Clear Mailjet fields
            $emailSetting->api_secret = null;
        } elseif ($request->input('provider') === 'mailjet') {
            $emailSetting->api_public = $request->input('api_public');
            $emailSetting->api_secret = $request->input('api_secret');
            $emailSetting->host = null; // Clear PHPMailer fields
            $emailSetting->port = null;
            $emailSetting->encryption = null;
            $emailSetting->username = null;
            $emailSetting->password = null;
        }

        // Save the settings
        $emailSetting->save();

        return redirect()->back()->with('success', 'Email settings updated successfully.');
    }

    public function test()
    {
        return view('admin.email.test', [
            'title' => 'Test Email',
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email|max:255',
            'test_message' => 'nullable|string|max:255',
        ]);

        try {
            // Send test email
            if (email_settings()->status ?? config('settings.email_notification')) {
                Mail::mailer(email_settings()->provider ?? config('settings.email_provider'))
                    ->to($request->recipient_email)
                    ->send(new TestEmail($request->test_message, $request->recipient_email));
            }

            return redirect()->back()->with('success', 'Test email sent successfully to ' . $request->recipient_email);
        } catch (Exception $e) {
            Log::error('Failed to send test email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
