class IconSelect {
    constructor(container) {
        this.container = container;
        this.trigger = container.querySelector('.custom-dropdown-trigger');
        this.dropdown = container.querySelector('.custom-dropdown-content');
        this.hiddenSelect = container.querySelector('.hidden-icon-select');
        this.iconPreview = container.querySelector('.selected-icon-preview');
        this.iconText = container.querySelector('.selected-icon-text');
        
        this.init();
    }
    
    init() {
        // Toggle dropdown visibility
        this.trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleDropdown();
        });
        
        // Handle option selection
        this.dropdown.querySelectorAll('.dropdown-option').forEach(option => {
            option.addEventListener('click', () => {
                this.selectOption(option);
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });
    }
    
    toggleDropdown() {
        this.dropdown.classList.toggle('hidden');
        
        // Close other open dropdowns
        document.querySelectorAll('.icon-select-component .custom-dropdown-content:not(.hidden)').forEach(otherDropdown => {
            if (otherDropdown !== this.dropdown) {
                otherDropdown.classList.add('hidden');
            }
        });
    }
    
    closeDropdown() {
        this.dropdown.classList.add('hidden');
    }
    
    selectOption(option) {
        const value = option.getAttribute('data-value');
        const iconName = option.getAttribute('data-icon-name');
        const iconImage = option.getAttribute('data-icon-image');
        
        // Update hidden select
        this.hiddenSelect.value = value;
        
        // Update display
        this.iconPreview.innerHTML = `<img src="${iconImage}" alt="${iconName}" class="w-5 h-5">`;
        this.iconText.textContent = iconName;
        
        // Close dropdown
        this.closeDropdown();
        
        // Dispatch change event
        this.hiddenSelect.dispatchEvent(new Event('change'));
    }
    
    // Public method to set value programmatically
    setValue(value) {
        const option = this.dropdown.querySelector(`[data-value="${value}"]`);
        if (option) {
            this.selectOption(option);
        }
    }
    
    // Public method to get value
    getValue() {
        return this.hiddenSelect.value;
    }
}

// Initialize all icon selects on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.icon-select-component').forEach(container => {
        new IconSelect(container);
    });
});

// Make it available globally
window.IconSelect = IconSelect;