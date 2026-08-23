{{-- OneSignal Web Push SDK Integration --}}
@php
    $oneSignalAppId = config('onesignal.app_id');
    $safariWebId = config('onesignal.safari_web_id');
    $authAdmin = auth('admin')->user();
    $authUser = auth()->user();
    $currentUserId = $authAdmin ? 'admin_' . $authAdmin->id : ($authUser ? 'user_' . $authUser->id : null);
    $currentUserEmail = $authAdmin?->email ?? $authUser?->email ?? null;
@endphp

@if($oneSignalAppId)
    <!-- OneSignal Web Push SDK -->
    <script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
        window.OneSignalDeferred = window.OneSignalDeferred || [];
        OneSignalDeferred.push(async function(OneSignal) {
            await OneSignal.init({
                appId: "{{ $oneSignalAppId }}",
                @if($safariWebId)
                safari_web_id: "{{ $safariWebId }}",
                @endif
                allowLocalhostAsSecureOrigin: true,
                notifyButton: {
                    enable: false, // Customized prompt trigger available via triggerPushPrompt()
                },
            });

            @if($currentUserId)
                // Identify authenticated user in OneSignal
                try {
                    await OneSignal.login("{{ $currentUserId }}");
                    @if($currentUserEmail)
                        await OneSignal.User.addEmail("{{ $currentUserEmail }}");
                    @endif
                } catch (e) {
                    console.debug("[OneSignal] User identification notice:", e);
                }
            @endif
        });

        // Helper function to trigger notification opt-in prompt anywhere in the UI
        window.triggerPushPrompt = async function() {
            if (window.OneSignalDeferred) {
                window.OneSignalDeferred.push(async function(OneSignal) {
                    try {
                        await OneSignal.Slidedown.promptPush();
                    } catch (err) {
                        console.error("[OneSignal] Error triggering push prompt:", err);
                    }
                });
            }
        };
    </script>
@endif
