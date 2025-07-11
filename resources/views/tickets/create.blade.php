<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Create Ticket</h1>
        <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Title</label>
                <input type="text" name="title" class="form-input w-full" required value="{{ old('title') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Description</label>
                <div class="flex items-center gap-2">
                    <textarea name="description" id="description" class="form-input w-full" rows="5" required>{{ old('description') }}</textarea>
                    <button type="button" id="ai-generate-description" class="btn bg-blue-500 text-white hover:bg-blue-600" title="AI Generate Description">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    </button>
                </div>
                <div id="ai-desc-spinner" class="hidden text-xs text-blue-500 mt-1">Generating description...</div>
            </div>
            <script>
                document.getElementById('ai-generate-description').addEventListener('click', function() {
                    const title = document.querySelector('input[name=title]').value;
                    const spinner = document.getElementById('ai-desc-spinner');
                    spinner.classList.remove('hidden');
                    fetch("{{ route('tickets.ai.generateDescription') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                        },
                        body: JSON.stringify({ title })
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('description').value = data.description;
                        spinner.classList.add('hidden');
                    });
                });
            </script>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Category</label>
                <select name="category_id" class="form-input w-full">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(old('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Status</label>
                <select name="status_id" class="form-input w-full">
                    @foreach($statuses as $status)
                        <option value="{{ $status->id }}" @if(old('status_id') == $status->id) selected @endif>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Priority</label>
                <select name="priority" class="form-input w-full">
                    <option value="low" @if(old('priority') == 'low') selected @endif>Low</option>
                    <option value="normal" @if(old('priority', 'normal') == 'normal') selected @endif>Normal</option>
                    <option value="high" @if(old('priority') == 'high') selected @endif>High</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Assign To</label>
                <select name="assigned_to" class="form-input w-full">
                    <option value="">Unassigned</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" @if(old('assigned_to') == $user->id) selected @endif>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Attachment</label>
                <input type="file" name="attachment" class="form-input w-full">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn bg-violet-500 text-white hover:bg-violet-600">Submit Ticket</button>
            </div>
        </form>
    </div>
</x-app-layout> 