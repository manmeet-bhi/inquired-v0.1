@extends('layouts.cms')

@section('title', 'Edit User - CMS')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('cms.users') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">
                Edit User: {{ $user->name }}
            </h1>
        </div>

        <form action="{{ route('cms.users.update', $user) }}" 
              method="POST" class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
            @csrf
            @method('PUT')

            <div class="cms-form-group">
                <label class="cms-label" for="name">
                    Full Name <span class="text-rose-500">*</span>
                </label>
                <input class="cms-input @error('name') border-red-500 @enderror" 
                       id="name" name="name" type="text" placeholder="John Doe" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="cms-form-group">
                <label class="cms-label" for="email">
                    Email Address <span class="text-rose-500">*</span>
                </label>
                <input class="cms-input @error('email') border-red-500 @enderror" 
                       id="email" name="email" type="email" placeholder="john@example.com" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="cms-form-group">
                <label class="cms-label" for="role">
                    Role <span class="text-rose-500">*</span>
                </label>
                <select class="cms-select" id="role" name="role" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="cms-form-group">
                    <label class="cms-label" for="password">
                        New Password (optional)
                    </label>
                    <input class="cms-input @error('password') border-red-500 @enderror" 
                           id="password" name="password" type="password" placeholder="Leave blank to keep current">
                    @error('password')
                        <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="cms-form-group">
                    <label class="cms-label" for="password_confirmation">
                        Confirm New Password
                    </label>
                    <input class="cms-input" 
                           id="password_confirmation" name="password_confirmation" type="password">
                </div>
            </div>

            <div class="cms-form-group">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" 
                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all mr-3">
                    <span class="cms-label !mb-0">Active Account</span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button class="cms-btn cms-btn-primary w-full sm:w-auto" type="submit">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">Update User Account</span>
                </button>
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                    <a href="{{ route('cms.users') }}" 
                       class="cms-btn cms-btn-secondary w-full sm:w-auto text-center order-2 sm:order-1">
                        Cancel
                    </a>
                    <a href="{{ route('cms.permissions.edit', $user) }}" 
                       class="cms-btn bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-100 w-full sm:w-auto text-center order-1 sm:order-2">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Manage Permissions</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection