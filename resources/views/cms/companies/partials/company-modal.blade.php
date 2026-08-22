<!-- Company Modal Backdrop -->
<div id="company-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <!-- Modal Content -->
    <div class="cms-card w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border-none">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                <i data-lucide="building-2" class="w-6 h-6 text-indigo-600"></i>
                Quick Add Company
            </h3>
            <button type="button" onclick="closeCompanyModal()" class="w-10 h-10 flex items-center justify-center rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <form id="quick-company-form" class="p-6 space-y-6" data-ajax="true" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company Name -->
                <div class="cms-form-group md:col-span-2">
                    <label for="company_modal_name" class="cms-label">Company Name <span class="text-rose-500">*</span></label>
                    <input type="text" id="company_modal_name" name="name" required class="cms-input" placeholder="e.g. Acme Corp">
                    <p class="mt-1 text-sm text-red-600 hidden error-name font-semibold"></p>
                </div>

                <!-- Industry -->
                <div class="cms-form-group">
                    <label for="company_modal_industry" class="cms-label">Industry</label>
                    <input type="text" id="company_modal_industry" name="industry" class="cms-input" placeholder="e.g. Technology">
                    <p class="mt-1 text-sm text-red-600 hidden error-industry font-semibold"></p>
                </div>

                <!-- Website -->
                <div class="cms-form-group">
                    <label for="company_modal_website" class="cms-label">Website</label>
                    <input type="url" id="company_modal_website" name="website" class="cms-input" placeholder="https://example.com">
                    <p class="mt-1 text-sm text-red-600 hidden error-website font-semibold"></p>
                </div>

                <!-- Company Type -->
                <div class="cms-form-group">
                    <label for="company_modal_type" class="cms-label">Type</label>
                    <select id="company_modal_type" name="type" class="cms-select">
                        <option value="">Select Type</option>
                        <option value="startup">Startup</option>
                        <option value="sme">SME</option>
                        <option value="mnc">MNC</option>
                        <option value="indian_mnc">Indian MNCs</option>
                        <option value="enterprise">Enterprise</option>
                        <option value="unicorn">Unicorn</option>
                    </select>
                </div>

                <!-- Logo (Simple file input) -->
                <div class="cms-form-group">
                    <label for="company_modal_logo" class="cms-label">Company Logo</label>
                    <input type="file" id="company_modal_logo" name="logo" accept="image/*" class="cms-input text-xs">
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button type="submit" id="save-company-btn" class="cms-btn cms-btn-primary w-full sm:w-auto order-1 sm:order-2">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Save Company</span>
                </button>
                <button type="button" onclick="closeCompanyModal()" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center order-2 sm:order-1">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCompanyModal() {
    document.getElementById('company-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
}

function closeCompanyModal() {
    document.getElementById('company-modal').classList.add('hidden');
    document.body.style.overflow = '';
    document.getElementById('quick-company-form').reset();
    document.querySelectorAll('#quick-company-form .text-red-600').forEach(el => el.classList.add('hidden'));
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quick-company-form');
    const saveBtn = document.getElementById('save-company-btn');
    const btnText = saveBtn ? saveBtn.querySelector('.btn-text') : null;

    if (form && saveBtn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            document.querySelectorAll('#quick-company-form .text-red-600').forEach(el => el.classList.add('hidden'));
            
            saveBtn.disabled = true;
            if (btnText) btnText.textContent = 'Saving...';

            const formData = new FormData(form);

            fetch("{{ route('cms.companies.store') }}", {
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
                    // Success!
                    const companySelect = document.getElementById('company_id');
                    if (companySelect && isJson) {
                        const newId = body.company.id;
                        const newName = body.company.name;
                        
                        // Add to original select
                        const option = new Option(newName, newId, true, true);
                        companySelect.add(option);
                        
                        // Force update of searchable dropdown instance if it exists
                        const container = companySelect.closest('.searchable-dropdown-wrapper') || companySelect.previousElementSibling;
                        if (container && container.classList.contains('searchable-dropdown-wrapper')) {
                            const input = container.querySelector('.searchable-dropdown-input');
                            if (input) input.value = newName;
                        }
                    }
                    
                    alert('Company added successfully!');
                    closeCompanyModal();
                } else if (status === 422 && isJson) {
                    Object.keys(body.errors).forEach(key => {
                        const errorEl = document.querySelector(`#quick-company-form .error-${key}`);
                        if (errorEl) {
                            errorEl.textContent = body.errors[key][0];
                            errorEl.classList.remove('hidden');
                        }
                    });
                } else {
                    alert('Error: ' + (body.message || 'Something went wrong'));
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                saveBtn.disabled = false;
                if (btnText) btnText.textContent = 'Save Company';
            });
        });
    }
});
</script>
