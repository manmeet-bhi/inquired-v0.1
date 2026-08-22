@extends('layouts.cms')

@section('title', 'Google & MSN Indexing - CMS')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                <i data-lucide="search" class="w-8 h-8 text-blue-600"></i>
                Google & MSN Indexing
            </h1>
            <p class="text-slate-600 mt-2">Manage Google and MSN (Bing) site verification and sitemaps</p>
        </div>
        <a href="{{ route('cms.seo.index') }}" class="inline-flex items-center text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-4 py-2 rounded-lg transition-colors whitespace-nowrap">
            <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
            Back to SEO
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
            <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center">
            <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Site Verification Upload -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center">
                    <i data-lucide="upload-cloud" class="w-5 h-5 mr-2 text-blue-600"></i>
                    Upload HTML Verification File
                </h2>
            </div>
            <div class="p-8">
                <p class="text-sm text-slate-600 mb-6">Upload the HTML verification file provided by Google Search Console or Bing Webmaster Tools. The file will be placed in the public root directory for mass indexing verification.</p>
                
                <form action="{{ route('cms.seo.indexing.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-5">
                        <label for="verification_file" class="block text-sm font-semibold text-slate-700 mb-2">HTML File</label>
                        <input type="file" name="verification_file" id="verification_file" accept=".html" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-slate-50 transition-colors hover:bg-white text-sm transition-colors" required>
                        <p class="text-xs text-slate-500 mt-2">Only .html files are allowed (Max: 1MB).</p>
                    </div>
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                        <i data-lucide="upload" class="w-4 h-4 mr-2"></i>
                        Upload File
                    </button>
                </form>

                @if(count($verificationFiles) > 0)
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-medium text-slate-900 mb-4">Uploaded Verification Files</h3>
                    <ul class="space-y-3">
                        @foreach($verificationFiles as $file)
                            <li class="flex items-center justify-between text-sm bg-slate-50 p-3 rounded-lg border border-slate-200">
                                <span class="text-slate-700 font-medium truncate flex-1 mr-4">
                                    <i data-lucide="file-code" class="w-4 h-4 inline-block mr-2 text-slate-400"></i>
                                    {{ $file }}
                                </span>
                                <div class="flex items-center gap-3">
                                    <a href="{{ asset($file) }}" target="_blank" class="text-blue-600 hover:text-blue-800 transition-colors flex items-center" title="View">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('cms.seo.indexing.delete') }}" method="POST" class="inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="file_name" value="{{ $file }}">
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors flex items-center" onclick="return confirm('Are you sure you want to delete this file? This might break your site verification.')" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        <!-- Sitemap Generation -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden h-fit">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center">
                    <i data-lucide="map" class="w-5 h-5 mr-2 text-green-600"></i>
                    Sitemap Generation
                </h2>
            </div>
            <div class="p-8">
                <p class="text-sm text-slate-600 mb-6">Generate an XML sitemap for your website and notify search engines automatically about your updated content.</p>
                
                <div class="mb-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Sitemap URL</label>
                    <div class="flex">
                        <input type="text" id="sitemap_url" value="{{ url('/sitemap.xml') }}" class="w-full px-3 py-2 border border-slate-300 rounded-l-lg bg-white text-slate-600 focus:outline-none" readonly>
                        <button type="button" onclick="copyToClipboard('sitemap_url')" class="bg-slate-200 text-slate-700 px-4 py-2 rounded-r-lg hover:bg-slate-300 transition-colors border-y border-r border-slate-300 flex items-center focus:outline-none focus:ring-2 focus:ring-slate-400 group" title="Copy to clipboard">
                            <i data-lucide="copy" class="w-4 h-4 group-hover:text-slate-900 transition-colors"></i>
                        </button>
                    </div>
                </div>

                <form action="{{ route('cms.seo.sitemap.generate') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 whitespace-nowrap">
                        <i data-lucide="refresh-cw" class="w-4 h-4 mr-2"></i>
                        Generate Sitemap
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        
        let initialText = copyText.value;
        copyText.value = 'Copied to clipboard!';
        setTimeout(() => {
            copyText.value = initialText;
        }, 2000);
    }
</script>
@endsection
