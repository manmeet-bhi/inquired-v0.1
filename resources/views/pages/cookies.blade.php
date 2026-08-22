@extends('layouts.app')

@section('title', 'Cookie Policy - Anywhereroles')

@section('content')
<div class="bg-white">


    <main class="max-w-4xl mx-auto px-6 py-12">
        <div class="text-sm text-gray-500 mb-4">Last Updated: February 2026</div>
        <div class="bg-white rounded-2xl border border-gray-100 p-8 space-y-8">
            <!-- Introduction -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">What Are Cookies</h2>
                <p class="text-gray-600 leading-relaxed">
                    Cookies are small text files stored on your device when you visit a website. They are widely used to make websites work more efficiently and provide information to website owners.
                </p>
            </section>

            <!-- How We Use Cookies -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How We Use Cookies</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Anywhereroles uses cookies to enhance your browsing experience and provide personalized services. 
                    We use cookies for the following purposes:
                </p>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>To remember user preferences and improve browsing experience</li>
                    <li>To analyze website traffic and usage patterns</li>
                    <li>To improve website functionality and user experience</li>
                    <li>To prevent fraud and enhance security</li>
                </ul>
            </section>

            <!-- Types of Cookies -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Types of Cookies We Use</h2>
                
                <div class="space-y-6">
                    <div class="border-l-4 border-blue-500 pl-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Essential Cookies</h3>
                        <p class="text-gray-600 leading-relaxed">
                            These cookies are necessary for the website to function properly. They enable basic functions 
                            like page navigation, access to secure areas, and authentication.
                        </p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Performance Cookies</h3>
                        <p class="text-gray-600 leading-relaxed">
                            These cookies collect information about how visitors use our website, such as which pages 
                            are visited most often. This data helps us improve website performance.
                        </p>
                    </div>

                    <div class="border-l-4 border-purple-500 pl-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Functionality Cookies</h3>
                        <p class="text-gray-600 leading-relaxed">
                            These cookies allow the website to remember choices you make and provide enhanced, 
                            personalized features such as saved job preferences.
                        </p>
                    </div>

                    <div class="border-l-4 border-orange-500 pl-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics Cookies</h3>
                        <p class="text-gray-600 leading-relaxed">
                            We use analytics cookies to understand how our website is being used and to improve 
                            our services based on user behavior patterns.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Third-Party Cookies -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Third-Party Cookies</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Anywhereroles may use third-party services that place cookies on your device when you visit our website. These cookies help us understand how users interact with our platform and improve our services.
                </p>
                <p class="text-gray-600 mb-3">These services may include:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-2 mb-3">
                    <li>Google Analytics (to analyze website traffic)</li>
                    <li>Content delivery networks (for faster website performance)</li>
                    <li>Social media integrations (for sharing content)</li>
                </ul>
                <p class="text-gray-600">These third-party services have their own privacy and cookie policies.</p>
            </section>

            <!-- External Websites -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">External Websites</h2>
                <p class="text-gray-600 leading-relaxed">
                    Some links on Anywhereroles redirect users to external websites such as company career pages or job application portals. These external websites may use their own cookies and tracking technologies, which are not controlled by Anywhereroles.
                </p>
                <p class="text-gray-600">We recommend reviewing the cookie and privacy policies of those websites.</p>
            </section>

            <!-- Managing Cookies -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Managing Your Cookie Preferences</h2>
                <div class="bg-blue-50 rounded-xl p-6 mb-4">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-4 mt-1">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Browser Settings</h3>
                            <p class="text-gray-600 leading-relaxed">
                                You can control and manage cookies through your browser settings. Most browsers allow you to:
                            </p>
                            <ul class="list-disc list-inside text-gray-600 mt-2 space-y-1">
                                <li>View what cookies are stored on your device</li>
                                <li>Delete cookies individually or all at once</li>
                                <li>Block cookies from specific websites</li>
                                <li>Block all cookies</li>
                                <li>Set preferences for different types of cookies</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Chrome</h4>
                        <p class="text-sm text-gray-600">Settings → Privacy and Security → Cookies and other site data</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Firefox</h4>
                        <p class="text-sm text-gray-600">Options → Privacy & Security → Cookies and Site Data</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Safari</h4>
                        <p class="text-sm text-gray-600">Preferences → Privacy → Manage Website Data</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Edge</h4>
                        <p class="text-sm text-gray-600">Settings → Cookies and site permissions → Cookies and site data</p>
                    </div>
                </div>
            </section>

            <!-- Cookie Consent -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Cookie Consent</h2>
                <p class="text-gray-600 leading-relaxed">
                    By continuing to use our website, you agree to the use of cookies as described in this Cookie Policy. You can manage or disable cookies at any time through your browser settings.
                </p>
            </section>

            <!-- Impact of Disabling Cookies -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Impact of Disabling Cookies</h2>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-xl">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-yellow-700">
                                Please note that disabling cookies may affect the functionality of our website. 
                                Some features may not work properly, and you may not be able to access certain areas 
                                or receive personalized content.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Updates to Cookie Policy -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Updates to This Cookie Policy</h2>
                <p class="text-gray-600 leading-relaxed">
                    We may update this Cookie Policy from time to time to reflect changes in our practices or for other 
                    operational, legal, or regulatory reasons. We encourage you to review this policy periodically.
                </p>
            </section>

            <!-- Contact -->
            <section class="bg-blue-50 rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Questions About Cookies</h2>
                <p class="text-gray-600 leading-relaxed">
                    If you have any questions about our use of cookies or this Cookie Policy, please contact us at:
                </p>
                <div class="mt-4 text-gray-600">
                    <p>Email: anywhereroles@gmail.com</p>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection