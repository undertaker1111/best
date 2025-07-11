<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Permissions Management</h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Permissions</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}<br><span class="text-xs text-gray-400">{{ $user->email }}</span></td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->roles->pluck('name')->join(', ') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->permissions->pluck('name')->join(', ') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button type="button" class="btn bg-violet-500 text-white" onclick="document.getElementById('perm-modal-{{ $user->id }}').classList.remove('hidden')">Assign Permissions</button>
                                <!-- Modal/Section for permissions -->
                                <div id="perm-modal-{{ $user->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md">
                                        <h2 class="text-lg font-semibold mb-4">Assign Permissions to {{ $user->name }}</h2>
                                        <form action="{{ route('permissions.assign') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <div class="mb-4 grid grid-cols-1 gap-2">
                                                @foreach($permissions as $permission)
                                                    <label class="flex items-center">
                                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-checkbox" @if($user->hasPermissionTo($permission->name)) checked @endif>
                                                        <span class="ml-2">{{ $permission->name }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" class="btn bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-100" onclick="document.getElementById('perm-modal-{{ $user->id }}').classList.add('hidden')">Cancel</button>
                                                <button type="submit" class="btn bg-violet-500 text-white">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
        // Close modal on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^=perm-modal-]').forEach(function(modal) {
                    modal.classList.add('hidden');
                });
            }
        });
        </script>
    </div>
</x-app-layout> 