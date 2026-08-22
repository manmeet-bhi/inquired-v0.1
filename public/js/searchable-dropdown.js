class SearchableDropdown {
    constructor(element, options = {}) {
        this.element = element;
        this.options = {
            searchUrl: element.getAttribute('data-search-url') || options.searchUrl || '/cms/api/companies/search',
            placeholder: options.placeholder || 'Search companies...',
            minChars: options.minChars || 3,
            debounceTime: options.debounceTime || 300,
            ...options
        };
        
        this.isOpen = false;
        this.selectedValue = '';
        this.selectedText = '';
        this.searchTimeout = null;
        
        this.init();
    }
    
    init() {
        this.createDropdownHTML();
        this.bindEvents();
        this.setInitialValue();
    }
    
    createDropdownHTML() {
        const wrapper = document.createElement('div');
        wrapper.className = 'searchable-dropdown-wrapper relative';
        
        wrapper.innerHTML = `
            <div class="searchable-dropdown-container">
                <input type="text" 
                       class="searchable-dropdown-input cms-input text-slate-800" 
                       placeholder="${this.options.placeholder}"
                       autocomplete="off">
                <div class="searchable-dropdown-arrow absolute right-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div class="searchable-dropdown-menu absolute z-50 w-full mt-1 bg-white border border-slate-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                    <div class="searchable-dropdown-loading p-3 text-center text-slate-500 hidden">
                        <div class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Searching...
                        </div>
                    </div>
                    <div class="searchable-dropdown-results"></div>
                    <div class="searchable-dropdown-no-results p-3 text-center text-slate-500 hidden">
                        No companies found
                    </div>
                </div>
            </div>
        `;
        
        this.element.parentNode.insertBefore(wrapper, this.element);
        this.element.style.display = 'none';
        
        this.wrapper = wrapper;
        this.input = wrapper.querySelector('.searchable-dropdown-input');
        this.menu = wrapper.querySelector('.searchable-dropdown-menu');
        this.loading = wrapper.querySelector('.searchable-dropdown-loading');
        this.results = wrapper.querySelector('.searchable-dropdown-results');
        this.noResults = wrapper.querySelector('.searchable-dropdown-no-results');
    }
    
    bindEvents() {
        // Input events
        this.input.addEventListener('input', (e) => {
            this.handleInput(e.target.value);
        });
        
        this.input.addEventListener('focus', () => {
            if (this.input.value.length >= this.options.minChars) {
                this.showMenu();
            }
        });
        
        this.input.addEventListener('blur', (e) => {
            // Delay hiding to allow for clicks on menu items
            setTimeout(() => {
                if (!this.wrapper.contains(document.activeElement)) {
                    this.hideMenu();
                }
            }, 150);
        });
        
        // Click outside to close
        document.addEventListener('click', (e) => {
            if (!this.wrapper.contains(e.target)) {
                this.hideMenu();
            }
        });
        
        // Keyboard navigation
        this.input.addEventListener('keydown', (e) => {
            this.handleKeydown(e);
        });
    }
    
    setInitialValue() {
        const selectedOption = this.element.querySelector('option:checked');
        if (selectedOption && selectedOption.value) {
            this.selectedValue = selectedOption.value;
            this.selectedText = selectedOption.textContent;
            this.input.value = this.selectedText;
        }
    }
    
    handleInput(value) {
        clearTimeout(this.searchTimeout);
        
        if (value.length < this.options.minChars) {
            this.hideMenu();
            this.clearSelection();
            return;
        }
        
        this.searchTimeout = setTimeout(() => {
            this.search(value);
        }, this.options.debounceTime);
    }
    
    async search(query) {
        this.showLoading();
        this.showMenu();
        
        try {
            console.log('Searching for:', query);
            console.log('Using URL:', `${this.options.searchUrl}?q=${encodeURIComponent(query)}`);
            
            const response = await fetch(`${this.options.searchUrl}?q=${encodeURIComponent(query)}`);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const data = await response.json();
            console.log('API Response:', data);
            
            this.hideLoading();
            this.displayResults(data.companies || []);
        } catch (error) {
            console.error('Search error:', error);
            this.hideLoading();
            this.showNoResults();
        }
    }
    
    displayResults(companies) {
        this.results.innerHTML = '';
        this.hideNoResults();
        
        if (companies.length === 0) {
            this.showNoResults();
            return;
        }
        
        companies.forEach((company, index) => {
            const item = document.createElement('div');
            item.className = 'searchable-dropdown-item px-4 py-2 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-b-0';
            item.setAttribute('data-value', company.id);
            item.setAttribute('data-index', index);
            
            item.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-1">
                        <div class="font-medium text-slate-900">${this.escapeHtml(company.name)}</div>
                        ${company.industry ? `<div class="text-sm text-slate-500">${this.escapeHtml(company.industry)}</div>` : ''}
                    </div>
                </div>
            `;
            
            item.addEventListener('click', () => {
                this.selectItem(company.id, company.name);
            });
            
            this.results.appendChild(item);
        });
    }
    
    selectItem(value, text) {
        this.selectedValue = value;
        this.selectedText = text;
        this.input.value = text;
        this.element.value = value;
        
        // Trigger change event on original select
        const event = new Event('change', { bubbles: true });
        this.element.dispatchEvent(event);
        
        this.hideMenu();
        this.clearHighlight();
    }
    
    clearSelection() {
        this.selectedValue = '';
        this.selectedText = '';
        this.element.value = '';
        
        // Trigger change event
        const event = new Event('change', { bubbles: true });
        this.element.dispatchEvent(event);
    }
    
    handleKeydown(e) {
        const items = this.results.querySelectorAll('.searchable-dropdown-item');
        const highlighted = this.results.querySelector('.searchable-dropdown-item.highlighted');
        
        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                this.highlightNext(items, highlighted);
                break;
            case 'ArrowUp':
                e.preventDefault();
                this.highlightPrev(items, highlighted);
                break;
            case 'Enter':
                e.preventDefault();
                if (highlighted) {
                    const value = highlighted.getAttribute('data-value');
                    const text = highlighted.querySelector('.font-medium').textContent;
                    this.selectItem(value, text);
                }
                break;
            case 'Escape':
                this.hideMenu();
                this.input.blur();
                break;
        }
    }
    
    highlightNext(items, current) {
        this.clearHighlight();
        if (!current) {
            if (items.length > 0) {
                items[0].classList.add('highlighted', 'bg-blue-50');
            }
        } else {
            const index = parseInt(current.getAttribute('data-index'));
            if (index < items.length - 1) {
                items[index + 1].classList.add('highlighted', 'bg-blue-50');
            }
        }
    }
    
    highlightPrev(items, current) {
        this.clearHighlight();
        if (!current) {
            if (items.length > 0) {
                items[items.length - 1].classList.add('highlighted', 'bg-blue-50');
            }
        } else {
            const index = parseInt(current.getAttribute('data-index'));
            if (index > 0) {
                items[index - 1].classList.add('highlighted', 'bg-blue-50');
            }
        }
    }
    
    clearHighlight() {
        const highlighted = this.results.querySelectorAll('.highlighted');
        highlighted.forEach(item => {
            item.classList.remove('highlighted', 'bg-blue-50');
        });
    }
    
    showMenu() {
        this.menu.classList.remove('hidden');
        this.isOpen = true;
    }
    
    hideMenu() {
        this.menu.classList.add('hidden');
        this.isOpen = false;
        this.clearHighlight();
    }
    
    showLoading() {
        this.loading.classList.remove('hidden');
        this.hideNoResults();
    }
    
    hideLoading() {
        this.loading.classList.add('hidden');
    }
    
    showNoResults() {
        this.noResults.classList.remove('hidden');
    }
    
    hideNoResults() {
        this.noResults.classList.add('hidden');
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Auto-initialize dropdowns
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.searchable-company-dropdown');
    dropdowns.forEach(dropdown => {
        new SearchableDropdown(dropdown, {
            placeholder: 'Type to search companies...',
            minChars: 3
        });
    });
});

// Export for manual initialization
window.SearchableDropdown = SearchableDropdown;