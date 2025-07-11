<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">AI & Automations</h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <p class="text-gray-700 dark:text-gray-300 mb-4">Integrate AI to automate ticket suggestions, auto-replies, and more. You can use free APIs like <a href='https://platform.openai.com/' class='underline text-violet-600' target='_blank'>OpenAI</a> or <a href='https://huggingface.co/inference-api' class='underline text-violet-600' target='_blank'>Hugging Face</a>.</p>
            <form action="{{ route('ai.saveApiKey') }}" method="POST">
                @csrf
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">API Key</label>
                <input type="text" name="api_key" class="form-input w-full mb-4" placeholder="Enter your OpenAI or Hugging Face API key">
                <button type="submit" class="btn bg-violet-500 text-white hover:bg-violet-600">Save API Key</button>
            </form>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-2">Sample Integration</h2>
            <p class="text-gray-700 dark:text-gray-300">Once you add your API key, you can use AI to automate ticket triage, suggest replies, or summarize tickets. See <a href='https://platform.openai.com/docs/guides/gpt' class='underline text-violet-600' target='_blank'>OpenAI docs</a> or <a href='https://huggingface.co/docs/api-inference/index' class='underline text-violet-600' target='_blank'>Hugging Face docs</a> for more info.</p>
        </div>
    </div>
</x-app-layout> 