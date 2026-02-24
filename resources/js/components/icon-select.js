class IconSelect {
    constructor(container) {
        this.container = container;
        this.trigger = container.querySelector('.custom-dropdown-trigger');
        this.dropdown = container.querySelector('.custom-dropdown-content');
        this.hiddenSelect = container.querySelector('select');
        this.iconPreview = container.querySelector('.selected-icon-preview');
        this.iconText = container.querySelector('.selected-icon-text');
        
        this.init();
    }
    
    init() {
        this.trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleDropdown();
        });
        
        this.dropdown.querySelectorAll('.dropdown-option').forEach(option => {
            option.addEventListener('click', () => {
                this.selectOption(option);
            });
        });
        
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });
    }
    
    toggleDropdown() {
        this.dropdown.classList.toggle('hidden');
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
        
        this.hiddenSelect.value = value;
        this.iconPreview.innerHTML = `<img src="${iconImage}" alt="${iconName}" class="w-5 h-5">`;
        this.iconText.textContent = iconName;
        this.closeDropdown();
        this.hiddenSelect.dispatchEvent(new Event('change'));
    }
    
    setValue(value) {
        const option = this.dropdown.querySelector(`[data-value="${value}"]`);
        if (option) {
            this.selectOption(option);
        }
    }
    
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