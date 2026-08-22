<!-- Modal Backdrop -->
<div id="category-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <!-- Modal Content -->
    <div class="cms-card w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border-none">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="tag" class="w-6 h-6 text-indigo-600"></i>
                Add New Category
            </h3>
            <button type="button" onclick="closeCategoryModal()" class="w-10 h-10 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <form id="quick-category-form" class="p-6 space-y-6" data-ajax="true">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="cms-form-group">
                    <label for="modal_name" class="cms-label">Category Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="modal_name" name="name" required class="cms-input" placeholder="e.g. Development">
                    <p class="mt-1 text-sm text-red-600 hidden error-name font-semibold"></p>
                </div>

                <!-- Slug -->
                <div>
                    <label for="modal_slug" class="block text-sm font-medium text-slate-700 mb-2">Slug *</label>
                    <input type="text" id="modal_slug" name="slug" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-red-600 hidden error-slug"></p>
                </div>

                <!-- Icon -->
                <div>
                    <label for="modal_icon" class="block text-sm font-medium text-slate-700 mb-2">Icon (Emoji or HTML)</label>
                    <input type="text" id="modal_icon" name="icon" placeholder="💻 or <i class='icon'></i>" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-red-600 hidden error-icon"></p>
                </div>

                <!-- Color -->
                <div>
                    <label for="modal_color" class="block text-sm font-medium text-slate-700 mb-2">Color</label>
                    <input type="color" id="modal_color" name="color" value="#3B82F6" class="w-full h-10 px-2 py-1 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <p class="mt-1 text-sm text-red-600 hidden error-color"></p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="modal_description" class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                    <textarea id="modal_description" name="description" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <p class="mt-1 text-sm text-red-600 hidden error-description"></p>
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="modal_is_active" name="is_active" value="1" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        <label for="modal_is_active" class="ml-2 text-sm font-medium text-slate-700">Active</label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" id="save-category-btn" class="cms-btn cms-btn-primary w-full sm:w-auto order-1 sm:order-2">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Save Category</span>
                </button>
                <button type="button" onclick="closeCategoryModal()" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center order-2 sm:order-1">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCategoryModal() {
    document.getElementById('category-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function closeCategoryModal() {
    document.getElementById('category-modal').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('quick-category-form').reset();
    resetErrors();
}

function resetErrors() {
    document.querySelectorAll('#quick-category-form .text-red-600').forEach(el => el.classList.add('hidden'));
}

document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('modal_name');
    const slugInput = document.getElementById('modal_slug');

    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        });
    }

    const form = document.getElementById('quick-category-form');
    const saveBtn = document.getElementById('save-category-btn');
    const btnText = saveBtn ? saveBtn.querySelector('.btn-text') : null;
    const btnLoader = saveBtn ? saveBtn.querySelector('.btn-loader') : null;

    if (form && saveBtn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            resetErrors();
            
            saveBtn.disabled = true;
            if (btnText) btnText.textContent = 'Saving...';
            if (btnLoader) btnLoader.classList.remove('hidden');

            const formData = new FormData(form);

            fetch("{{ route('cms.categories.store') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                const isJson = contentType && contentType.includes('application/json');
                const body = isJson ? await response.json() : await response.text();
                return { status: response.status, body, isJson };
            })
            .then(({ status, body, isJson }) => {
                if (status === 200 || status === 201) {
                    // Success
                    const categorySelect = document.getElementById('category_id');
                    if (categorySelect && isJson) {
                        const option = new Option(body.category.name, body.category.id, true, true);
                        categorySelect.add(option);
                    }
                    
                    alert('Category added successfully!');
                    closeCategoryModal();
                } else if (status === 422 && isJson) {
                    // Validation error
                    Object.keys(body.errors).forEach(key => {
                        const errorEl = document.querySelector(`#quick-category-form .error-${key}`);
                        if (errorEl) {
                            errorEl.textContent = body.errors[key][0];
                            errorEl.classList.remove('hidden');
                        }
                    });
                } else {
                    console.error('Server response:', body);
                    alert('Something went wrong. Please check the console for details.');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                saveBtn.disabled = false;
                if (btnText) btnText.textContent = 'Save Category';
                if (btnLoader) btnLoader.classList.add('hidden');
            });
        });
    }
});
</script>
