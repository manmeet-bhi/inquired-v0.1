@extends('layouts.cms')

@section('title', 'Manage Permissions - CMS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Manage Admin Permissions</h1>
            <p class="text-slate-500 mt-2">Grant or revoke specific access rights to CMS managers.</p>
        </div>
        <a href="{{ route('cms.users') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm font-semibold text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i> Back to Users
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-xl mb-6 shadow-sm flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-3 text-green-500"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-6 py-4">Admin User</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Permissions Active</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($adminUsers as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold shadow-sm border border-indigo-100 shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800">{{ $user->name }}</h3>
                                        <p class="text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold leading-5 bg-blue-50 text-blue-700 border border-blue-200 uppercase tracking-widest">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->permissions && $user->permissions->count() > 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                                        {{ $user->permissions->count() }} Permitted
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        No Access Configured
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('cms.permissions.edit', $user) }}" 
                                   class="inline-flex items-center bg-indigo-50 hover:bg-indigo-600 text-indigo-600 hover:text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors shadow-sm border border-indigo-100 hover:border-indigo-600 group-hover:shadow-md">
                                    <i data-lucide="shield" class="w-4 h-4 mr-2"></i> Manage Permissions
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i data-lucide="shield-off" class="w-12 h-12 mb-4 text-slate-200"></i>
                                    <p class="text-base font-medium text-slate-600">No manageable admin users found.</p>
                                    <p class="text-sm mt-1">Super Admins manage permissions and bypass granular access checks.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection