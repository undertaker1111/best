<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class AIService
{
    protected $provider;
    protected $openAiKey;
    protected $geminiKey;

    public function __construct()
    {
        $setting = Setting::first();
        $this->provider = $setting?->ai_provider ?? 'openai';
        $this->openAiKey = $setting?->ai_key;
        $this->geminiKey = $setting?->gemini_key;
    }

    protected function callOpenAI($prompt, $maxTokens = 100)
    {
        if (!$this->openAiKey) {
            return 'No OpenAI API key configured.';
        }
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->openAiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/completions', [
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'max_tokens' => $maxTokens,
            'temperature' => 0.7,
        ]);
        if ($response->successful()) {
            return trim($response['choices'][0]['text'] ?? '');
        }
        return 'AI error: ' . $response->body();
    }

    protected function callGemini($prompt, $maxTokens = 100)
    {
        if (!$this->geminiKey) {
            return 'No Gemini API key configured.';
        }
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-goog-api-key' => $this->geminiKey,
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ],
            'generationConfig' => [
                'maxOutputTokens' => $maxTokens,
                'temperature' => 0.7,
            ],
        ]);
        if ($response->successful()) {
            return trim($response['candidates'][0]['content']['parts'][0]['text'] ?? '');
        }
        return 'AI error: ' . $response->body();
    }

    protected function callProvider($prompt, $maxTokens = 100)
    {
        if ($this->provider === 'gemini') {
            return $this->callGemini($prompt, $maxTokens);
        }
        return $this->callOpenAI($prompt, $maxTokens);
    }

    public function suggestDescription($title)
    {
        $prompt = "Write a clear, helpful support ticket description for this issue title: '$title'";
        return $this->callProvider($prompt, 80);
    }

    public function suggestReply($ticket)
    {
        $prompt = "You are a helpful IT support agent. Suggest a professional reply to this ticket: '" . $ticket->description . "'";
        return $this->callProvider($prompt, 80);
    }

    public function suggestSolution($ticket)
    {
        $prompt = "Suggest a step-by-step solution for this IT support ticket: '" . $ticket->description . "'";
        return $this->callProvider($prompt, 100);
    }

    public function suggestNextAction($ticket)
    {
        $prompt = "Given this ticket: '" . $ticket->description . "', what should the support team do next?";
        return $this->callProvider($prompt, 60);
    }
} 