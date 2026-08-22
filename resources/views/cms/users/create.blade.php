@extends('layouts.cms')

@section('title', isset($user) ? 'Edit User - CMS' : 'Create User - CMS')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('cms.users') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ isset($user) ? 'Edit User' : 'Create New User' }}
            </h1>
        </div>

        <form action="{{ isset($user) ? route('cms.users.update', $user) : route('cms.users.store') }}" 
              method="POST" class="cms-card p-6 lg:p-10 mb-8 overflow-visible">
            @csrf
            @if(isset($user))
                @method('PUT')
            @endif

            <div class="cms-form-group">
                <label class="cms-label" for="name">
                    Full Name <span class="text-rose-500">*</span>
                </label>
                <input class="cms-input @error('name') border-red-500 @enderror" 
                       id="name" name="name" type="text" placeholder="John Doe" value="{{ old('name', $user->name ?? '') }}" required>
                @error('name')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="cms-form-group">
                <label class="cms-label" for="email">
                    Email Address <span class="text-rose-500">*</span>
                </label>
                <input class="cms-input @error('email') border-red-500 @enderror" 
                       id="email" name="email" type="email" placeholder="john@example.com" value="{{ old('email', $user->email ?? '') }}" required>
                @error('email')
                    <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="cms-form-group">
                <label class="cms-label" for="role">
                    Role <span class="text-rose-500">*</span>
                </label>
                <select class="cms-select" id="role" name="role" required>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ old('role', $user->role ?? '') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="cms-form-group">
                    <label class="cms-label" for="password">
                        Password {{ isset($user) ? '(optional)' : '*' }}
                    </label>
                    <input class="cms-input @error('password') border-red-500 @enderror" 
                           id="password" name="password" type="password" {{ !isset($user) ? 'required' : '' }}>
                    @error('password')
                        <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="cms-form-group">
                    <label class="cms-label" for="password_confirmation">
                        Confirm Password {{ !isset($user) ? '*' : '' }}
                    </label>
                    <input class="cms-input" 
                           id="password_confirmation" name="password_confirmation" type="password" {{ !isset($user) ? 'required' : '' }}>
                </div>
            </div>

            @if(isset($user))
                <div class="cms-form-group">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" 
                               {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all mr-3">
                        <span class="cms-label !mb-0">Active Account</span>
                    </label>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-100">
                <button class="cms-btn cms-btn-primary w-full sm:w-auto" type="submit">
                    <span class="btn-spinner"></span>
                    <span class="btn-text">{{ isset($user) ? 'Update User Account' : 'Create User Account' }}</span>
                </button>
                <a href="{{ route('cms.users') }}" 
                   class="cms-btn cms-btn-secondary w-full sm:w-auto text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection