@extends('layouts.cms')

@section('title', 'Users - CMS')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Admin Users</h1>
        <a href="{{ route('cms.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-center font-medium shadow-lg shadow-blue-500/20 transition-all active:scale-95">
            Add New User
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @forelse($users as $user)
                <li class="px-4 sm:px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="text-lg font-bold text-gray-900 truncate">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                            <div class="flex flex-wrap items-center mt-2 gap-3 sm:gap-4">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $user->role === 'superadmin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $user->role }}
                                </span>
                                <span class="text-xs font-medium flex items-center {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $user->is_active ? 'bg-green-600' : 'bg-red-600' }}"></span>
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    Joined {{ $user->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-end sm:justify-start space-x-3 sm:space-x-4 border-t sm:border-t-0 pt-3 sm:pt-0">
                            <a href="{{ route('cms.users.edit', $user) }}" 
                               class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">Edit User</a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('cms.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 text-sm font-semibold"
                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-4 text-center text-gray-500">
                    No admin users found. <a href="{{ route('cms.users.create') }}" class="text-blue-600">Create one now</a>
                </li>
            @endforelse
        </ul>
    </div>

    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
