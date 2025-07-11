<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function storeApiKey(Request $request)
    {
        // You can save the API key to the user, settings, or .env as needed
        // For now, just flash a message
        return redirect()->route('ai.placeholder')->with('success', 'API key saved!');
    }
} 