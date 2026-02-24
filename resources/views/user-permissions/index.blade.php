<x-app-layout>
<div class="w-[95%] container mx-auto py-8">
   <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold mb-6">User Permission Management</h1>
            <a href="{{ url('/permissions') }}">
                <button type="button" class="bg-green-700 text-white px-3 py-1 rounded hover:bg-green-600">
                    + Add New Permission
                </button>
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 mb-4">
                {{ session('success') }}
            </div>
        @endif


    @foreach ($users as $user)
    <div class="mb-8 border p-4 rounded-lg">
        <h2 class="text-lg font-semibold mb-3">{{ $user->name }} ({{ $user->email }})</h2>
        <form action="{{ route('user.permissions.update', $user->id) }}" method="POST" class="user-permissions-form">
            @csrf

            <!-- Superadmin Checkbox -->
            <div class="mb-4">
    <label class="flex items-center space-x-2">
        <input type="checkbox" class="superadmin-checkbox" data-user-id="{{ $user->id }}">
        <span>Make Superadmin (Select All Permissions)</span>
    </label>
</div>

            @foreach ($permissions as $module => $modulePermissions)
                <div class="mb-4">
                    <!-- Module Select All Checkbox -->
                    <label class="flex items-center space-x-2 mb-2">
                        <input type="checkbox" class="module-checkbox" data-user-id="{{ $user->id }}" data-module="{{ $module }}"
                            {{ $user->permissions->where('module', $module)->count() == count($modulePermissions) ? 'checked' : '' }}>
                        <span class="font-semibold">{{ ucfirst($module) }} (Select All)</span>
                    </label>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        @foreach ($modulePermissions as $permission)
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" 
                                       class="permission-checkbox" 
                                       name="permissions[]" 
                                       value="{{ $permission->id }}"
                                       data-user-id="{{ $user->id }}"
                                       data-module="{{ $module }}"
                                       {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                <span>{{ $permission->label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                Save
            </button>
        </form>
    </div>
    @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Superadmin: check all permissions for this user
    document.querySelectorAll('.superadmin-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const checked = this.checked;
            document.querySelectorAll(`.permission-checkbox[data-user-id="${userId}"]`).forEach(pcb => {
                pcb.checked = checked;
            });
            // Also check/uncheck all module checkboxes
            document.querySelectorAll(`.module-checkbox[data-user-id="${userId}"]`).forEach(mc => mc.checked = checked);
        });
    });

    // Module checkbox: select all permissions of this module for this user
    document.querySelectorAll('.module-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const module = this.dataset.module;
            const checked = this.checked;
            document.querySelectorAll(`.permission-checkbox[data-user-id="${userId}"][data-module="${module}"]`).forEach(pcb => {
                pcb.checked = checked;
            });

            // If all module checkboxes are checked, check superadmin
            const allModulesChecked = Array.from(document.querySelectorAll(`.module-checkbox[data-user-id="${userId}"]`))
                .every(mc => mc.checked);
            document.querySelector(`.superadmin-checkbox[data-user-id="${userId}"]`).checked = allModulesChecked;
        });
    });

    // Individual permission checkbox: update module and superadmin checkbox accordingly
    document.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const module = this.dataset.module;

            // Module checkbox
            const modulePermissions = document.querySelectorAll(`.permission-checkbox[data-user-id="${userId}"][data-module="${module}"]`);
            const allChecked = Array.from(modulePermissions).every(p => p.checked);
            document.querySelector(`.module-checkbox[data-user-id="${userId}"][data-module="${module}"]`).checked = allChecked;

            // Superadmin checkbox
            const allModuleCheckboxes = document.querySelectorAll(`.module-checkbox[data-user-id="${userId}"]`);
            const allModulesChecked = Array.from(allModuleCheckboxes).every(mc => mc.checked);
            document.querySelector(`.superadmin-checkbox[data-user-id="${userId}"]`).checked = allModulesChecked;
        });
    });

});
</script>
</x-app-layout>
