<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">Edit User</h1>
        <form action="{{ route('users.update', $user) }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Name</label>
                <input type="text" name="name" class="form-input w-full" required value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Email</label>
                <input type="email" name="email" class="form-input w-full" required value="{{ old('email', $user->email) }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Role</label>
                <select name="role" class="form-input w-full" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" @if($user->roles->first()?->name == $role->name) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Permissions</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($permissions as $permission)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-checkbox permission-checkbox" @if(in_array($permission->name, $userPermissions)) checked @endif>
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="text-xs text-gray-500 mt-1">Permissions are pre-selected based on the chosen role, but you can override them.</div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const roleSelect = document.querySelector('select[name=role]');
                    const checkboxes = document.querySelectorAll('.permission-checkbox');
                    const rolePermissions = {
                        @foreach($roles as $role)
                            '{{ $role->name }}': @json($role->permissions->pluck('name')->toArray()),
                        @endforeach
                    };
                    function setPermissionsForRole(role) {
                        checkboxes.forEach(cb => {
                            cb.checked = rolePermissions[role]?.includes(cb.value);
                        });
                    }
                    roleSelect.addEventListener('change', function() {
                        setPermissionsForRole(this.value);
                    });
                });
            </script>
            <div class="flex justify-end">
                <button type="submit" class="btn bg-violet-500 text-white hover:bg-violet-600">Update User</button>
            </div>
        </form>
    </div>
</x-app-layout> 