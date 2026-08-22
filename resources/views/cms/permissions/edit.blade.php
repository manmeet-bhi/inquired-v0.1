@extends('layouts.cms')

@section('title', 'Edit Permissions - CMS')

@section('content')
<style>
    /* Modern Pure CSS Toggle Switch Implementation - Inline to bypass caching */
    .cms-toggle { position: relative; display: inline-block; width: 2.75rem; height: 1.5rem; flex-shrink: 0; }
    .cms-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
    .cms-toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #e2e8f0; transition: .3s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 9999px; border: 1px solid #cbd5e1; }
    .cms-toggle-slider:before { position: absolute; content: ""; height: 1.125rem; width: 1.125rem; left: 2px; bottom: 2px; background-color: white; transition: .3s cubic-bezier(0.4, 0, 0.2, 1); border-radius: 50%; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    .cms-toggle input:checked + .cms-toggle-slider { background-color: #4f46e5; border-color: #4f46e5; }
    .cms-toggle input:focus-visible + .cms-toggle-slider { box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2); }
    .cms-toggle input:checked + .cms-toggle-slider:before { transform: translateX(1.25rem); }
</style>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Edit Permissions: <span class="text-indigo-600">{{ $adminUser->name }}</span>
            </h1>
            <p class="text-slate-500 mt-2 text-sm">Fine-tune the granular access levels for this administrative user.</p>
        </div>
        <a href="{{ route('cms.permissions.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm font-semibold text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back to Permissions
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-xl mb-6 shadow-sm flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-xl mb-6 shadow-sm flex items-center">
            <i data-lucide="x-circle" class="w-5 h-5 mr-3 text-red-500"></i>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('cms.permissions.update', $adminUser) }}" class="cms-card p-6 lg:p-10 space-y-10 overflow-visible">
        @csrf
        @method('PUT')
        
        @foreach($permissions as $category => $categoryPermissions)
        <div class="bg-slate-50/50 rounded-2xl p-6 border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-6 pb-3 border-b border-slate-200 flex items-center gap-3">
                <span class="w-1.5 h-6 bg-indigo-500 rounded-full"></span>
                {{ $category }} Management
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($categoryPermissions as $permission)
                <label class="flex items-center justify-between p-4 rounded-xl border border-slate-200 bg-white hover:border-indigo-300 hover:ring-2 hover:ring-indigo-50 transition-all cursor-pointer group shadow-sm hover:shadow">
                    <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-700 transition-colors select-none tracking-wide">
                        {{ $permission->display_name }}
                    </span>
                    <div class="ml-4 shrink-0 flex items-center">
                        <span class="cms-toggle mb-0">
                            <input type="checkbox" 
                                   name="permissions[]" 
                                   value="{{ $permission->name }}"
                                   id="perm_{{ $permission->id }}"
                                   {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>
                            <span class="cms-toggle-slider"></span>
                        </span>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach
        
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 mt-12 pt-8 border-t border-slate-200">
            <a href="{{ route('cms.permissions.index') }}" class="cms-btn cms-btn-secondary w-full sm:w-auto text-center order-2 sm:order-1 font-semibold text-slate-600 hover:text-slate-900 border-none bg-transparent hover:bg-slate-100 shadow-none px-6 shadow-sm">
                Cancel Changes
            </a>
            <button type="submit" class="cms-btn cms-btn-primary w-full sm:w-auto order-1 sm:order-2 shadow-lg shadow-indigo-500/20 px-8 py-3 rounded-xl flex items-center justify-center gap-2">
                <span class="btn-spinner"></span>
                <i data-lucide="shield-check" class="w-5 h-5"></i>
                <span class="btn-text">Save Access Levels</span>
            </button>
        </div>
    </form>
</div>
@endsection