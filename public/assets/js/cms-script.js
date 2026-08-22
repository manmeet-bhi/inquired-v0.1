// Enhanced CMS JavaScript for Better User Experience

// Initialize enhanced features when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeEnhancedFeatures();
    
    // Global Form Submit Loading State
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('.cms-btn-primary');
            if (submitBtn && !submitBtn.dataset.noSpinner) {
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;
                const btnText = submitBtn.querySelector('.btn-text');
                if (btnText && !submitBtn.dataset.loadingText) {
                    submitBtn.dataset.originalText = btnText.textContent;
                    // Optional: change text if needed
                }
            }
        });
    });
});

function initializeEnhancedFeatures() {
    // Add smooth scrolling
    addSmoothScrolling();
    
    // Initialize drag and drop for images
    initializeDragDrop();
    
    // Add form validation enhancements
    enhanceFormValidation();
    
    // Initialize tooltips
    initializeTooltips();
    
    // Add writing mode toggle
    addWritingModeToggle();
}

// Smooth scrolling for anchor links
function addSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Enhanced drag and drop for image uploads
function initializeDragDrop() {
    const dropArea = document.querySelector('.drag-drop-area');
    if (!dropArea) return;
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });
    
    dropArea.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight(e) {
        dropArea.classList.add('dragover');
    }
    
    function unhighlight(e) {
        dropArea.classList.remove('dragover');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            const fileInput = document.getElementById('featured-image-input');
            fileInput.files = files;
            
            // Trigger change event to show preview
            const event = new Event('change', { bubbles: true });
            fileInput.dispatchEvent(event);
        }
    }
}

// Enhanced form validation with better UX
function enhanceFormValidation() {
    const form = document.querySelector('form');
    if (!form) return;
    
    // Real-time validation
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearValidationError);
    });
    
    function validateField(e) {
        const field = e.target;
        const value = field.value.trim();
        
        if (!value) {
            showFieldError(field, 'This field is required');
        } else {
            clearFieldError(field);
        }
    }
    
    function clearValidationError(e) {
        clearFieldError(e.target);
    }
    
    function showFieldError(field, message) {
        clearFieldError(field);
        
        field.classList.add('border-red-500', 'error-shake');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-500 text-sm mt-1 flex items-center gap-1 validation-error';
        errorDiv.innerHTML = `<i data-lucide="alert-circle" class="w-4 h-4"></i>${message}`;
        
        field.parentNode.appendChild(errorDiv);
        lucide.createIcons();
        
        setTimeout(() => {
            field.classList.remove('error-shake');
        }, 500);
    }
    
    function clearFieldError(field) {
        field.classList.remove('border-red-500');
        const existingError = field.parentNode.querySelector('.validation-error');
        if (existingError) {
            existingError.remove();
        }
    }
}

// Initialize tooltips for toolbar buttons
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        element.classList.add('tooltip');
        element.setAttribute('data-tooltip', element.getAttribute('title'));
        element.removeAttribute('title');
    });
}

// Writing mode toggle (distraction-free mode)
function addWritingModeToggle() {
    const editorContainer = document.getElementById('editor-container');
    if (!editorContainer) return;
    
    // Add writing mode toggle button
    const toolbar = document.querySelector('.bg-gradient-to-r.from-slate-50');
    if (toolbar) {
        const writingModeBtn = document.createElement('button');
        writingModeBtn.type = 'button';
        writingModeBtn.className = 'flex items-center gap-2 px-4 py-2 bg-white rounded-lg border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors';
        writingModeBtn.innerHTML = '<i data-lucide="focus" class="w-4 h-4"></i><span>Focus Mode</span>';
        writingModeBtn.onclick = toggleWritingMode;
        
        toolbar.appendChild(writingModeBtn);
        lucide.createIcons();
    }
}

function toggleWritingMode() {
    const sidebar = document.querySelector('.lg\\:col-span-1');
    const mainContent = document.querySelector('.lg\\:col-span-3');
    const toolbar = document.querySelector('.bg-gradient-to-r.from-slate-50');
    
    if (document.body.classList.contains('writing-mode')) {
        // Exit writing mode
        document.body.classList.remove('writing-mode');
        sidebar.classList.remove('hidden');
        mainContent.classList.remove('lg:col-span-4');
        mainContent.classList.add('lg:col-span-3');
        toolbar.style.display = 'block';
    } else {
        // Enter writing mode
        document.body.classList.add('writing-mode');
        sidebar.classList.add('hidden');
        mainContent.classList.remove('lg:col-span-3');
        mainContent.classList.add('lg:col-span-4');
        toolbar.style.display = 'none';
    }
}

// Enhanced auto-save with visual feedback
function enhancedAutoSave() {
    let saveTimeout;
    const saveIndicator = document.createElement('div');
    saveIndicator.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transform translate-y-full transition-transform z-50';
    saveIndicator.innerHTML = '<i data-lucide="check" class="w-4 h-4 inline mr-2"></i>Saved';
    document.body.appendChild(saveIndicator);
    
    function showSaveIndicator() {
        saveIndicator.classList.remove('translate-y-full');
        setTimeout(() => {
            saveIndicator.classList.add('translate-y-full');
        }, 2000);
    }
    
    // Trigger save indicator when content changes
    const editor = document.getElementById('content-editor');
    if (editor) {
        editor.addEventListener('input', () => {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                showSaveIndicator();
            }, 1000);
        });
    }
    
    lucide.createIcons();
}

// Word suggestions and writing assistance
function initializeWritingAssistance() {
    const editor = document.getElementById('content-editor');
    if (!editor) return;
    
    let suggestionTimeout;
    
    editor.addEventListener('input', function() {
        clearTimeout(suggestionTimeout);
        suggestionTimeout = setTimeout(() => {
            analyzeWriting();
        }, 2000);
    });
    
    function analyzeWriting() {
        const text = editor.value;
        const wordCount = text.trim().split(/\s+/).length;
        const sentences = text.split(/[.!?]+/).length - 1;
        const avgWordsPerSentence = sentences > 0 ? Math.round(wordCount / sentences) : 0;
        
        // Show writing stats
        updateWritingStats(wordCount, sentences, avgWordsPerSentence);
    }
    
    function updateWritingStats(words, sentences, avgWords) {
        const statsContainer = document.querySelector('.writing-stats');
        if (statsContainer) {
            statsContainer.innerHTML = `
                <div class="text-xs text-slate-500 space-y-1">
                    <div>Words: ${words}</div>
                    <div>Sentences: ${sentences}</div>
                    <div>Avg words/sentence: ${avgWords}</div>
                </div>
            `;
        }
    }
}

// Initialize all enhanced features
enhancedAutoSave();
initializeWritingAssistance();