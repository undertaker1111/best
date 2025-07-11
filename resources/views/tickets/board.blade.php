<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Ticket Board</h1>
        <div class="flex gap-4 overflow-x-auto" x-data="{}">
            @foreach($statuses as $status)
                <div class="flex-1 min-w-[320px] bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold mb-4 text-center">{{ $status->name }}</h2>
                    <div class="space-y-4 min-h-[100px]" x-data="{dragging: null}">
                        @foreach($ticketsByStatus[$status->id] as $ticket)
                            <div class="bg-gray-50 dark:bg-gray-900 rounded p-3 shadow flex flex-col gap-2 border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <span class="font-semibold text-violet-600">{{ $ticket->title }}</span>
                                    <span class="text-xs px-2 py-1 rounded-full bg-{{ $ticket->priority == 'high' ? 'red' : ($ticket->priority == 'low' ? 'yellow' : 'gray') }}-200 text-{{ $ticket->priority == 'high' ? 'red' : ($ticket->priority == 'low' ? 'yellow' : 'gray') }}-800">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Str::limit($ticket->description, 60) }}</div>
                                <div class="flex items-center gap-2 mt-2">
                                    @if($ticket->assignedTo)
                                        <img src="{{ $ticket->assignedTo->profile_photo_url }}" class="w-6 h-6 rounded-full object-cover border-2 border-violet-400" title="Assigned: {{ $ticket->assignedTo->name }}">
                                    @else
                                        <span class="text-xs text-gray-400">Unassigned</span>
                                    @endif
                                    <span class="text-xs text-gray-400 ml-auto">#{{ $ticket->id }}</span>
                                </div>
                                <div class="flex gap-2 mt-2">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-xs bg-blue-500 text-white hover:bg-blue-600">View</a>
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-xs bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">Edit</a>
                                    <!-- AI badge if suggestion available (stub) -->
                                    <span class="ml-auto flex items-center gap-1 text-xs text-green-600" title="AI Suggestion Available">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /></svg>AI
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout> 