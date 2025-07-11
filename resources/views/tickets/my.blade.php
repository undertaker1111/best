<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">My Tickets</h1>
            <a href="{{ route('tickets.create') }}" class="btn bg-violet-500 text-white hover:bg-violet-600">Create Ticket</a>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created At</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tickets as $ticket)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ticket->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ticket->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ticket->status->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($ticket->priority) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-violet-600 hover:underline">View</a>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="ml-2 text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this ticket?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No tickets found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $tickets->links() }}</div>
    </div>
</x-app-layout> 