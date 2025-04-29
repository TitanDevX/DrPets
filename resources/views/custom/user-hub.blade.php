@extends('layouts/commonMaster')

@section('title', 'User')

@section('layoutContent')
<body class="bg-white">
    <div class="mb-5 d-flex justify-content-center">
        <a href="{{ url('/') }}" class="app-brand-link text-decoration-none d-flex flex-column align-items-center">
            <span class="app-brand-logo demo mb-2">
                @include('_partials.macros', ['width' => 300, 'withbg' => 'var(--bs-primary)'])
            </span>
          
        </a>
    </div>
    <div class="container text-center py-5">
        <h1 class="mb-4">Get the App Now!</h1>
        <p class="mb-4 text-muted">Download our app for the best experience on your device.</p>

        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="https://apps.apple.com/app/idYOUR_APP_ID" target="_blank">
                <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" 
                     alt="Download on the App Store" style="height: 60px;">
            </a>
            <a href="https://play.google.com/store/apps/details?id=YOUR_PACKAGE_NAME" target="_blank">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" 
                     alt="Get it on Google Play" style="height: 60px;">
            </a>
        </div>
    </div>

</body>
@endsection