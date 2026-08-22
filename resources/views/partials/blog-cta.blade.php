<div class="w-full py-8 md:py-12 px-4 flex justify-center">
    <div class="w-full max-w-4xl rounded-2xl p-6 lg:p-10 flex flex-col md:flex-row items-center justify-between gap-6 md:gap-8 shadow-sm" style="background-color: #F3E8FF;">
        
        <!-- Left Side: Icon and Text -->
        <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-4 md:gap-6 flex-1">
            <!-- Icon -->
            <div class="flex-shrink-0 bg-white p-4 rounded-full shadow-md">
                 <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#9333ea" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase md:w-10 md:h-10"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            </div>

            <!-- Text Content -->
            <div class="w-full">
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-2 md:mb-3">
                    Looking for a new opportunity?
                </h2>
                <p class="text-gray-600 text-sm md:text-base max-w-xl mx-auto md:mx-0">
                    Get access to over 5000 new job openings everyday across India.
                </p>
            </div>
        </div>

        <!-- Right Side: Button -->
        <div class="w-full md:w-auto flex-shrink-0 mt-2 md:mt-0">
            <a href="{{ route('jobs.index') }}" class="block w-full md:w-auto text-white font-semibold py-3.5 px-8 md:px-10 rounded-xl transition-all duration-200 text-center shadow-sm hover:shadow-md hover:opacity-90 active:scale-95 text-sm md:text-base whitespace-nowrap" style="background-color: #065F46;">
                View Jobs
            </a>
        </div>
    </div>
</div>
