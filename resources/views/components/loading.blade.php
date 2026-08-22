@props(['message' => 'Loading...'])

<div class="flex items-center justify-center py-12">
    <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
        <p class="text-slate-600">{{ $message }}</p>
    </div>
</div>