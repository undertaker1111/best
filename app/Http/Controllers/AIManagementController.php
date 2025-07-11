<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\AILog;
use Illuminate\Support\Arr;

class AIManagementController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        $aiProvider = $setting?->ai_provider ?? 'openai';
        $aiKey = $aiProvider === 'gemini' ? $setting?->gemini_key : $setting?->ai_key;
        $geminiKey = $setting?->gemini_key;
        $aiFeatures = $setting?->ai_features ?? [];
        // Twilio config (stored in ai_features['twilio'] if present)
        $twilio = $aiFeatures['twilio'] ?? [
            'enabled' => false,
            'account_sid' => '',
            'auth_token' => '',
            'whatsapp_number' => '',
        ];
        return view('ai.management', compact('aiProvider', 'aiKey', 'geminiKey', 'aiFeatures', 'twilio', 'setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate([]);
        // Handle enable/disable AI toggle
        if ($request->has('toggle_enabled')) {
            $setting->enabled = !$setting->enabled;
            $setting->save();
            return redirect()->route('ai.management')->with('success', 'AI status updated.');
        }
        $validated = $request->validate([
            'ai_provider' => 'required|in:openai,gemini',
            'ai_key' => 'nullable|string',
            'gemini_key' => 'nullable|string',
            'enable_description' => 'nullable|boolean',
            'enable_reply' => 'nullable|boolean',
            'enable_solution' => 'nullable|boolean',
            'twilio_enabled' => 'nullable|boolean',
            'twilio_account_sid' => 'nullable|string',
            'twilio_auth_token' => 'nullable|string',
            'twilio_whatsapp_number' => 'nullable|string',
        ]);
        $setting->ai_provider = $request->input('ai_provider', 'openai');
        $setting->ai_key = $request->input('ai_key');
        $setting->gemini_key = $request->input('gemini_key');
        $setting->enable_description = $request->has('enable_description');
        $setting->enable_reply = $request->has('enable_reply');
        $setting->enable_solution = $request->has('enable_solution');
        // Keep ai_features for Twilio and legacy
        $aiFeatures = $setting->ai_features ?? [];
        $aiFeatures['twilio'] = [
            'enabled' => $request->boolean('twilio_enabled'),
            'account_sid' => $request->input('twilio_account_sid'),
            'auth_token' => $request->input('twilio_auth_token'),
            'whatsapp_number' => $request->input('twilio_whatsapp_number'),
        ];
        $setting->ai_features = $aiFeatures;
        $setting->save();
        return redirect()->route('ai.management')->with('success', 'AI configuration updated.');
    }

    public function logs(Request $request)
    {
        $logs = AILog::with('user')->latest()->paginate(20);
        return view('ai.logs', compact('logs'));
    }
}
