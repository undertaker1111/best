<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">AI Config & Features</h1>
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center">
                <span class="font-semibold text-gray-700 dark:text-gray-200 mr-2">AI Status:</span>
                @if($setting?->enabled)
                    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Enabled</span>
                @else
                    <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Disabled</span>
                @endif
            </div>
            <form action="{{ route('ai.management.update') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="toggle_enabled" value="1">
                <button type="submit" class="btn btn-xs {{ $setting?->enabled ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white ml-2">
                    {{ $setting?->enabled ? 'Disable AI' : 'Enable AI' }}
                </button>
            </form>
        </div>
        <form action="{{ route('ai.management.update') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">AI Provider</label>
                <select name="ai_provider" id="ai_provider" class="form-input w-full" onchange="toggleApiKeyFields()">
                    <option value="openai" @if(old('ai_provider', $aiProvider ?? 'openai') == 'openai') selected @endif>OpenAI</option>
                    <option value="gemini" @if(old('ai_provider', $aiProvider ?? '') == 'gemini') selected @endif>Gemini (Google)</option>
                </select>
                <div class="text-xs text-gray-500 mt-1">Choose which AI provider to use for all features.</div>
            </div>
            <div class="mb-6" id="openai-key-field">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">OpenAI API Key</label>
                <input type="text" name="ai_key" class="form-input w-full" value="{{ $aiProvider == 'openai' ? $aiKey : '' }}" placeholder="Enter your OpenAI API key">
                <div class="text-xs text-gray-500 mt-1">This key will be used for all OpenAI-powered features.</div>
            </div>
            <div class="mb-6" id="gemini-key-field" style="display:none;">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Gemini API Key</label>
                <input type="text" name="gemini_key" class="form-input w-full" value="{{ $aiProvider == 'gemini' ? $geminiKey : '' }}" placeholder="Enter your Gemini API key">
                <div class="text-xs text-gray-500 mt-1">This key will be used for all Gemini-powered features.</div>
            </div>
            <script>
                function toggleApiKeyFields() {
                    var provider = document.getElementById('ai_provider').value;
                    document.getElementById('openai-key-field').style.display = provider === 'openai' ? '' : 'none';
                    document.getElementById('gemini-key-field').style.display = provider === 'gemini' ? '' : 'none';
                }
                document.addEventListener('DOMContentLoaded', toggleApiKeyFields);
            </script>
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Enable AI Features</label>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="enable_description" value="1" @if($setting?->enable_description) checked @endif>
                        <span class="ml-2">AI Description Generation</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="enable_reply" value="1" @if($setting?->enable_reply) checked @endif>
                        <span class="ml-2">AI Reply Suggestions</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="enable_solution" value="1" @if($setting?->enable_solution) checked @endif>
                        <span class="ml-2">AI Solution Suggestions</span>
                    </label>
                </div>
            </div>
            <div class="mb-6 border-t pt-6">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" /></svg>
                    <span class="font-semibold text-gray-700 dark:text-gray-200">WhatsApp Integration (Twilio)</span>
                </div>
                <div class="text-xs text-gray-500 mb-2">Twilio WhatsApp integration is not free for production. You can enable and configure it here if you decide to use it in the future.</div>
                <label class="inline-flex items-center mb-2">
                    <input type="checkbox" name="twilio_enabled" value="1" @if($twilio['enabled'] ?? false) checked @endif id="twilio-toggle">
                    <span class="ml-2">Enable WhatsApp Integration (Twilio)</span>
                </label>
                <div id="twilio-fields" class="space-y-2 mt-2 @if(!($twilio['enabled'] ?? false)) hidden @endif">
                    <input type="text" name="twilio_account_sid" class="form-input w-full" value="{{ $twilio['account_sid'] ?? '' }}" placeholder="Twilio Account SID">
                    <input type="text" name="twilio_auth_token" class="form-input w-full" value="{{ $twilio['auth_token'] ?? '' }}" placeholder="Twilio Auth Token">
                    <input type="text" name="twilio_whatsapp_number" class="form-input w-full" value="{{ $twilio['whatsapp_number'] ?? '' }}" placeholder="Twilio WhatsApp Number">
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toggle = document.getElementById('twilio-toggle');
                        const fields = document.getElementById('twilio-fields');
                        if(toggle) {
                            toggle.addEventListener('change', function() {
                                if(this.checked) { fields.classList.remove('hidden'); } else { fields.classList.add('hidden'); }
                            });
                        }
                    });
                </script>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn bg-violet-500 text-white hover:bg-violet-600">Save Configuration</button>
            </div>
        </form>
    </div>
</x-app-layout> 