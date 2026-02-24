<x-app-layout>
    <div class="w-[95%] mx-auto">
        <div class="container mx-auto mt-4">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold mb-4">SEO Meta Tags Management</h2>
                <div class="flex justify-end mb-4">
                    <button data-modal-target="seo-meta-modal" data-modal-toggle="seo-meta-modal"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Add New Meta Tags
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table id="seo-meta-table" class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Page Slug</th>
                            <th class="px-4 py-2 text-left">Title</th>
                            <th class="px-4 py-2 text-left">Keyword</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($metaTags as $meta)
                        <tr>
                            <form action="{{ route('seo.update', $meta->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td class="px-4 py-2">{{ $meta->id }}</td>
                                <td class="px-4 py-2">
                                    <input type="text" name="page_slug" value="{{ $meta->page_slug }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                </td>
                                <td class="px-4 py-2">
                                    <input type="text" name="title" value="{{ $meta->title }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                </td>
                                 <td class="px-4 py-2">
                                    <input type="text" name="keywords" value="{{ $meta->keywords }}"
                                        class="w-full border border-gray-300 rounded px-2 py-1" disabled>
                                </td>
                                <td class="px-4 py-2">
                                    <textarea name="description" 
                                        class="w-full border border-gray-300 rounded px-2 py-1" 
                                        rows="2" disabled>{{ $meta->description }}</textarea>
                                </td>
                                <td class="px-4 py-2 flex space-x-2">
                                    <button type="button" onclick="enableSeoEdit(this)"
                                        class="bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-500">Edit</button>
                                    <button type="submit"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 hidden save-seo-button">Save</button>
                            </form>
                            <form action="{{ route('seo.destroy', $meta->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmSeoDelete(this)"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Delete</button>
                            </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add New SEO Meta Modal -->
        <div id="seo-meta-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add New SEO Meta Tags</h3>
                        <button type="button" data-modal-hide="seo-meta-modal"
                            class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <form action="{{ route('seo.store') }}" method="POST">
                            @csrf
                            <div class="grid gap-4 grid-cols-1">
                                <div>
                                    <label for="page_slug" class="block text-sm font-medium text-gray-700">Page Slug*</label>
                                    <input type="text" id="page_slug" name="page_slug" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="e.g., home, about-us, contact">
                                </div>

                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title*</label>
                                    <input type="text" id="title" name="title" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Page title (50-60 characters)">
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description*</label>
                                    <textarea id="description" name="description" required rows="3"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Meta description (150-160 characters)"></textarea>
                                </div>

                                <div>
                                    <label for="keywords" class="block text-sm font-medium text-gray-700">Keywords</label>
                                    <input type="text" id="keywords" name="keywords"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Comma-separated keywords">
                                </div>

                                <div>
                                    <label for="header_snippet" class="block text-sm font-medium text-gray-700">Header Snippet</label>
                                    <textarea id="header_snippet" name="header_snippet" rows="3"
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Additional code for &lt;head&gt; section"></textarea>
                                </div>
                            </div>
                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Add Meta Tags
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function enableSeoEdit(button) {
        const row = button.closest('tr');
        row.querySelectorAll('input, textarea, select').forEach(field => field.disabled = false);
        button.classList.add('hidden');
        row.querySelector('.save-seo-button').classList.remove('hidden');
    }

    function confirmSeoDelete(button) {
        if (confirm('Are you sure you want to delete these meta tags?')) {
            button.closest('form').submit();
        }
    }

    // Character counters for SEO fields
    document.addEventListener('DOMContentLoaded', function() {
        // Title counter
        const titleField = document.getElementById('title');
        if (titleField) {
            titleField.addEventListener('input', function() {
                const length = this.value.length;
                const counter = document.getElementById('title-counter') || 
                    document.createElement('small');
                counter.id = 'title-counter';
                counter.className = 'text-xs text-gray-500 block mt-1';
                counter.textContent = `${length}/60 characters (recommended)`;
                
                if (!this.nextElementSibling || this.nextElementSibling.id !== 'title-counter') {
                    this.parentNode.appendChild(counter);
                }
            });
        }

        // Description counter
        const descField = document.getElementById('description');
        if (descField) {
            descField.addEventListener('input', function() {
                const length = this.value.length;
                const counter = document.getElementById('desc-counter') || 
                    document.createElement('small');
                counter.id = 'desc-counter';
                counter.className = 'text-xs text-gray-500 block mt-1';
                counter.textContent = `${length}/160 characters (recommended)`;
                
                if (!this.nextElementSibling || this.nextElementSibling.id !== 'desc-counter') {
                    this.parentNode.appendChild(counter);
                }
            });
        }
    });
    </script>
</x-app-layout>