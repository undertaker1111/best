<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Ticket Details</h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <div class="mb-2"><span class="font-semibold">Title:</span> {{ $ticket->title }}</div>
            <div class="mb-2"><span class="font-semibold">Description:</span> {{ $ticket->description }}</div>
            <div class="mb-2"><span class="font-semibold">Status:</span> {{ $ticket->status->name ?? '-' }}</div>
            <div class="mb-2"><span class="font-semibold">Priority:</span> {{ ucfirst($ticket->priority) }}</div>
            <div class="mb-2"><span class="font-semibold">Category:</span> {{ $ticket->category->name ?? '-' }}</div>
            <div class="mb-2"><span class="font-semibold">Created By:</span> {{ $ticket->user->name ?? '-' }}</div>
            <div class="mb-2"><span class="font-semibold">Created At:</span> {{ $ticket->created_at->format('Y-m-d H:i') }}</div>
            <div class="mb-2"><span class="font-semibold">Assigned To:</span> {{ $ticket->assignedTo?->name ?? '-' }}</div>
            <div class="mb-2"><span class="font-semibold">Status:</span> {{ $ticket->status->name ?? '-' }}</div>
            @if($ticket->attachment)
                <div class="mb-2"><span class="font-semibold">Attachment:</span> <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="underline">View Attachment</a></div>
            @endif
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Comments</h2>
            @forelse($ticket->comments as $comment)
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700 pb-2">
                    <div class="text-sm text-gray-700 dark:text-gray-300"><span class="font-semibold">{{ $comment->user->name ?? 'User' }}:</span> {{ $comment->comment }}</div>
                    <div class="text-xs text-gray-400 dark:text-gray-500">{{ $comment->created_at->format('Y-m-d H:i') }}</div>
                </div>
            @empty
                <div class="text-gray-500 dark:text-gray-400">No comments yet.</div>
            @endforelse
            @auth
            <form action="#" method="POST" class="mt-4" id="comment-form">
                @csrf
                <div class="flex items-center gap-2">
                    <textarea name="comment" id="comment-field" class="form-input w-full" rows="2" placeholder="Add a comment..."></textarea>
                    <button type="button" id="ai-suggest-comment" class="btn bg-blue-500 text-white hover:bg-blue-600" title="AI Suggest Comment">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    </button>
                </div>
                <div id="ai-comment-spinner" class="hidden text-xs text-blue-500 mt-1">Generating suggestion...</div>
                <div id="ai-comment-suggestion" class="hidden mt-2 bg-blue-50 dark:bg-blue-900 p-2 rounded text-sm">
                    <span id="ai-comment-text"></span>
                    <button type="button" id="accept-ai-comment" class="ml-2 btn bg-green-500 text-white hover:bg-green-600 btn-xs">Accept</button>
                </div>
                <div class="flex justify-end mt-2">
                    <button type="submit" class="btn bg-violet-500 text-white hover:bg-violet-600">Add Comment</button>
                </div>
            </form>
            <script>
                document.getElementById('ai-suggest-comment').addEventListener('click', function() {
                    const spinner = document.getElementById('ai-comment-spinner');
                    const suggestionBox = document.getElementById('ai-comment-suggestion');
                    const suggestionText = document.getElementById('ai-comment-text');
                    spinner.classList.remove('hidden');
                    fetch("{{ route('tickets.ai.suggestions', $ticket) }}")
                        .then(res => res.json())
                        .then(data => {
                            suggestionText.textContent = data.reply;
                            suggestionBox.classList.remove('hidden');
                            spinner.classList.add('hidden');
                        });
                });
                document.getElementById('accept-ai-comment').addEventListener('click', function() {
                    document.getElementById('comment-field').value = document.getElementById('ai-comment-text').textContent;
                });
            </script>
            @endauth
        </div>
        <div class="mt-8 bg-gray-50 dark:bg-gray-900 p-4 rounded">
            <h2 class="text-lg font-semibold mb-2">AI Suggestions</h2>
            <ul class="text-sm text-gray-700 dark:text-gray-300 list-disc pl-5">
                <li><strong>Reply:</strong> {{ $aiSuggestion['reply'] ?? '-' }}</li>
                <li><strong>Solution:</strong> {{ $aiSuggestion['solution'] ?? '-' }}</li>
                <li><strong>Next Action:</strong> {{ $aiSuggestion['next_action'] ?? '-' }}</li>
            </ul>
        </div>
        <div class="flex justify-between">
            <a href="{{ route('tickets.index') }}" class="btn bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">Back to Tickets</a>
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn bg-blue-500 text-white hover:bg-blue-600">Edit Ticket</a>
        </div>
    </div>
</x-app-layout> 