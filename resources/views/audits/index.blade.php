<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Audit Log</h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Properties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap flex items-center gap-2">
                                @if($log->causer && $log->causer->profile_photo_path)
                                    <img src="{{ asset('storage/' . $log->causer->profile_photo_path) }}" class="w-8 h-8 rounded-full object-cover" alt="User Avatar">
                                @else
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0 1 12 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" /></svg>
                                @endif
                                <div>
                                    <div class="font-semibold">{{ $log->causer?->name ?? 'System' }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->causer?->email ?? '' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->event === 'created')
                                    <svg class="inline w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                @elseif($log->event === 'updated')
                                    <svg class="inline w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16h16V4H4zm4 4h8v8H8V8z" /></svg>
                                @elseif($log->event === 'deleted')
                                    <svg class="inline w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                @else
                                    <svg class="inline w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /></svg>
                                @endif
                                {{ $log->event ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $log->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $log->properties['ip'] ?? $log->properties['ip_address'] ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button" class="text-violet-600 underline" onclick="document.getElementById('props-{{ $log->id }}').classList.toggle('hidden')">View</button>
                                <div id="props-{{ $log->id }}" class="hidden bg-gray-100 dark:bg-gray-900 p-2 mt-2 rounded text-xs max-w-xs overflow-x-auto">
                                    <pre>{{ json_encode($log->properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $logs->links() }}</div>
    </div>
</x-app-layout> 