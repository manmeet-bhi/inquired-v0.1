<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
    @if($featured->image)
    <div class="aspect-video bg-gradient-to-br from-slate-100 to-slate-200 relative overflow-hidden">
        <img src="{{ media_url($featured->image) }}" alt="{{ $featured->title }}" class="w-full h-full object-cover">
        @if($featured->badge_text)
        <div class="absolute top-3 left-3">
            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                {{ $featured->badge_color === 'blue' ? 'bg-blue-500 text-white' : '' }}
                {{ $featured->badge_color === 'green' ? 'bg-green-500 text-white' : '' }}
                {{ $featured->badge_color === 'red' ? 'bg-red-500 text-white' : '' }}
                {{ $featured->badge_color === 'yellow' ? 'bg-yellow-500 text-white' : '' }}
                {{ $featured->badge_color === 'purple' ? 'bg-purple-500 text-white' : '' }}
                {{ $featured->badge_color === 'pink' ? 'bg-pink-500 text-white' : '' }}
                {{ $featured->badge_color === 'indigo' ? 'bg-indigo-500 text-white' : '' }}">
                {{ $featured->badge_text }}
            </span>
        </div>
        @endif
    </div>
    @else
    <div class="aspect-video bg-gradient-to-br from-blue-500 to-blue-600 relative flex items-center justify-center">
        <i data-lucide="star" class="w-12 h-12 text-white"></i>
        @if($featured->badge_text)
        <div class="absolute top-3 left-3">
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-white/20 text-white backdrop-blur-sm">
                {{ $featured->badge_text }}
            </span>
        </div>
        @endif
    </div>
    @endif
    
    <div class="p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-2">{{ $featured->title }}</h3>
        @if($featured->description)
        <p class="text-slate-600 text-sm mb-4">{{ Str::limit($featured->description, 120) }}</p>
        @endif
        
        @php
            $url = $featured->url;
            if ($featured->type !== 'custom' && $featured->entity_id) {
                $url = match($featured->type) {
                    'blog' => route('blog.show', $featured->entity_id),
                    'company' => route('companies') . '#company-' . $featured->entity_id,
                    'job' => route('jobs.show', $featured->entity_id),
                    default => $featured->url
                };
            }
        @endphp
        
        @if($url)
        <a href="{{ $url }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm">
            Learn More
            <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
        </a>
        @endif
    </div>
</div>