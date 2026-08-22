function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const allDropdowns = document.querySelectorAll('.dropdown-menu');

    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== dropdownId) {
            d.classList.remove('show');
        }
    });

    // Toggle current dropdown
    dropdown.classList.toggle('show');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function (event) {
    if (!event.target.closest('.relative')) {
        document.querySelectorAll('.dropdown-menu').forEach(d => {
            d.classList.remove('show');
        });
    }
});

// Search Toggle Functionality
function toggleSearch() {
    const searchBar = document.getElementById('globalSearch');
    // Changed ID to match the new keyword input
    const searchInput = document.getElementById('global-search-keyword');
    const mobileMenu = document.getElementById('mobileMenu');

    if (!searchBar) return;

    const isHidden = searchBar.classList.contains('hidden');

    // Close mobile menu if open
    if (mobileMenu) {
        mobileMenu.classList.add('hidden');
    }

    // Toggle search
    if (isHidden) {
        searchBar.classList.remove('hidden');
        // Focus on the keyword input
        setTimeout(() => searchInput && searchInput.focus(), 100);
    } else {
        searchBar.classList.add('hidden');
    }
}

// Close search when clicking outside
document.addEventListener('click', function (event) {
    const searchBar = document.getElementById('globalSearch');
    const searchTrigger = event.target.closest('.search-trigger');
    const searchContent = event.target.closest('#globalSearch');

    if (!searchTrigger && !searchContent && searchBar && !searchBar.classList.contains('hidden')) {
        searchBar.classList.add('hidden');
    }
});

function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const searchBar = document.getElementById('globalSearch');
    const burgerIcon = document.getElementById('burger-icon');

    if (menu) {
        menu.classList.toggle('hidden');
    }

    if (burgerIcon) {
        burgerIcon.classList.toggle('open');
    }

    if (searchBar) {
        searchBar.classList.add('hidden');
    }
}

function toggleAccordion(id, btn) {
    if (window.event) window.event.stopPropagation();

    const content = document.getElementById(id);
    const chevron = btn ? btn.querySelector('.chevron') : null;

    // Close other top level accordions
    document.querySelectorAll('#mobileMenu .mobile-accordion').forEach(acc => {
        if (acc.id !== id && acc.classList.contains('active')) {
            acc.classList.remove('active');
            const parent = acc.closest('.rounded-xl') || acc.parentElement;
            const siblingBtn = parent ? parent.querySelector('button') : null;
            const siblingChevron = siblingBtn ? siblingBtn.querySelector('.chevron') : null;
            if (siblingChevron) {
                siblingChevron.style.transform = '';
            }
        }
    });

    if (content) {
        const isActive = content.classList.toggle('active');
        if (chevron) {
            chevron.style.transform = isActive ? 'rotate(225deg) translateY(-1px)' : '';
        }
    }
}

// Unified Search Logic - standard form submission is now used
document.addEventListener('DOMContentLoaded', function () {
    // Optional: any specific enhancements for search form can go here
});

// Expose functions to global scope for inline event handlers
window.toggleDropdown = toggleDropdown;
window.toggleSearch = toggleSearch;
window.toggleMenu = toggleMenu;
window.toggleAccordion = toggleAccordion;
