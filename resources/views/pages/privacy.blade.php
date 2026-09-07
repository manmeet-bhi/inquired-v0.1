@extends('layouts.app')

@section('title', 'Privacy Policy - Inaquired')

@section('content')
<div class="bg-white">


    <main class="max-w-4xl mx-auto px-6 py-12">
        <div class="text-sm text-gray-500 mb-4">Last Updated: February 2026</div>
        <div class="bg-white rounded-2xl border border-gray-100 p-8 space-y-8">
            <!-- Introduction -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Introduction</h2>
                <p class="text-gray-600 leading-relaxed">
                    At Inaquired, we value your privacy and are committed to protecting your information. This Privacy Policy explains how information is handled when you visit our website and use our services.
                </p>
            </section>

            <!-- Information We Collect -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Information We Collect</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Mandatory Personal Information</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Inaquired allows users to browse job listings without creating an account or submitting personal information such as name, email address, or phone number.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Technical and Log Data</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Like most websites, we may automatically collect limited technical information when you visit our website, including:
                        </p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2">
                            <li>IP address (partially anonymized where possible)</li>
                            <li>Browser type and device information</li>
                            <li>Pages visited</li>
                            <li>Date and time of access</li>
                            <li>Referring website</li>
                        </ul>
                        <p class="text-gray-600 leading-relaxed mt-2">This information is used only for:</p>
                        <ul class="list-disc list-inside text-gray-600 space-y-2">
                            <li>Website performance</li>
                            <li>Security monitoring</li>
                            <li>Improving user experience</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Cookies and Tracking Technologies</h3>
                        <p class="text-gray-600 leading-relaxed">
                            We use cookies and similar technologies to improve the functionality and performance of our website. Cookies help us understand how users interact with our platform and allow us to improve our services.
                        </p>
                        <p class="text-gray-600">For more details, please refer to our <a href="{{ route('cookies') }}" class="text-blue-600 hover:underline">Cookie Policy</a>.</p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Third-Party Services</h2>
                <p class="text-gray-600 leading-relaxed">
                    Inaquired may use trusted third-party services to operate and improve the website, such as analytics services, hosting providers, and content delivery networks (CDN). These providers may process limited technical data necessary for website functionality.
                </p>
            </section>

            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">External Job Listings</h2>
                <p class="text-gray-600 leading-relaxed">
                    Inaquired is a job aggregation platform that shares job opportunities collected from publicly available sources such as company career pages and recruitment portals.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    When you click on a job listing, you may be redirected to an external website to complete your application. These external websites operate independently and have their own privacy policies. We encourage users to review those policies before providing personal information.
                </p>
            </section>

            <!-- How We Use Your Information -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">How We Use Information</h2>
                <p class="text-gray-600 leading-relaxed mb-4">Since we do not collect personal data, we only use technical data to:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Maintain and secure our website</li>
                    <li>Monitor for technical issues or errors</li>
                    <li>Analyze aggregate usage trends to improve the user experience</li>
                </ul>
            </section>

            <!-- Information Sharing -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Information Sharing</h2>
                <p class="text-gray-600 leading-relaxed">
                    We do not sell or rent personal information to third parties. Since we do not require personal information to use the website, most users browse the platform anonymously.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Limited technical data may be processed by essential service providers only for website operation and security.
                </p>
            </section>

            <!-- Data Security -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Data Security</h2>
                <p class="text-gray-600 leading-relaxed">
                    We implement reasonable security measures to protect the website and its users. However, no method of internet transmission or electronic storage is completely secure.
                </p>
            </section>

            <!-- Your Rights -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Your Rights</h2>
                <p class="text-gray-600 leading-relaxed">
                    Since we do not require personal accounts or collect personal details directly, most users interact with our website anonymously.
                </p>
                <p class="text-gray-600 leading-relaxed mt-2">However, you may:</p>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Control cookies through browser settings</li>
                    <li>Disable tracking technologies</li>
                    <li>Stop using the website at any time</li>
                </ul>
            </section>

            <!-- Cookies -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Cookies</h2>
                <p class="text-gray-600 leading-relaxed">
                    We use cookies and similar technologies to enhance your experience on our website. 
                    You can control cookie settings through your browser preferences. 
                    For more information, see our <a href="{{ route('cookies') }}" class="text-blue-600 hover:underline">Cookie Policy</a>.
                </p>
            </section>

            <!-- Changes to Privacy Policy -->
            <section>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Changes to This Privacy Policy</h2>
                <p class="text-gray-600 leading-relaxed">
                    We may update this Privacy Policy from time to time. We will notify you of any changes by posting 
                    the new Privacy Policy on this page and updating the "Last updated" date.
                </p>
            </section>

            <!-- Contact -->
            <section class="bg-blue-50 rounded-xl p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Contact Us</h2>
                <p class="text-gray-600 leading-relaxed">
                    If you have any questions about this Privacy Policy, please contact us at:
                </p>
                <div class="mt-4 text-gray-600">
                    <p>Email: inaquired@gmail.com</p>
                </div>
            </section>
        </div>
    </main>
</div>
@endsection