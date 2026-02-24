@props(['name', 'required' => false, 'selected' => null, 'icons' => []])

<div class="relative icon-select-component">
    <!-- Hidden select for form submission -->
    <select name="{{ $name }}" class="hidden" {{ $required ? 'required' : '' }}>
        <option value="" disabled {{ !$selected ? 'selected' : '' }}>Select a facility icon</option>
        @foreach ($icons as $iconOption)
            <option value="{{ $iconOption->id }}" 
                    {{ $selected == $iconOption->id ? 'selected' : '' }}>
                {{ $iconOption->icon_name }}
            </option>
        @endforeach
    </select>
    
    <!-- Custom dropdown trigger -->
    <div class="custom-dropdown-trigger mt-1 p-2 border border-gray-300 rounded-md w-full bg-white cursor-pointer flex items-center justify-between">
        <div class="flex items-center">
            <span class="selected-icon-preview mr-2">
                @if($selected)
                    @php
                        $selectedIcon = $icons->firstWhere('id', $selected);
                    @endphp
                    @if($selectedIcon)
                        <img src="{{ asset('storage/' . $selectedIcon->image) }}" alt="{{ $selectedIcon->icon_name }}" class="w-5 h-5">
                    @endif
                @endif
            </span>
            <span class="selected-icon-text">
                @if($selected && isset($selectedIcon) && $selectedIcon)
                    {{ $selectedIcon->icon_name }}
                @else
                    Select a facility icon
                @endif
            </span>
        </div>
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
    
    <!-- Custom dropdown content -->
    <div class="custom-dropdown-content absolute left-0 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden max-h-60 overflow-y-auto">
        @foreach ($icons as $iconOption)
            <div class="dropdown-option flex items-center px-3 py-2 cursor-pointer hover:bg-blue-50" 
                 data-value="{{ $iconOption->id }}" 
                 data-icon-name="{{ $iconOption->icon_name }}"
                 data-icon-image="{{ asset('storage/' . $iconOption->image) }}">
                <img src="{{ asset('storage/' . $iconOption->image) }}" alt="{{ $iconOption->icon_name }}" class="w-5 h-5 mr-2">
                <span>{{ $iconOption->icon_name }}</span>
            </div>
        @endforeach
    </div>
</div>