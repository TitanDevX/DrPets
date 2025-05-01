<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error {{ $code }} - {{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: white;
            display: flex;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            max-width: 500px;
            text-align: center;
        }
        .error-code {
            font-size: 5rem;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="mb-5 d-flex justify-content-center">
            <a href="{{ url('/') }}" class="app-brand-link text-decoration-none d-flex flex-column align-items-center">
                <span class="app-brand-logo demo mb-2">
                    @include('_partials.macros', ['width' => 300, 'withbg' => 'var(--bs-primary)'])
                </span>
              
            </a>
        </div>

        <div class="error-code">{{ $code }}</div>
        <h2 class="mb-3">{{ $title }}</h2>
        <p class="text-muted mb-4">{{ $message }}</p>
        
    
    
    

        <a href="{{ url('/') }}" class="btn btn-primary">Go to Homepage</a>
    </div>
    @if(config('app.debug') && isset($exception))
        <div class="text-start bg-white p-3 mt-4 rounded border shadow-sm">
            <h5 class="text-danger">Stack Trace</h5>
            <div class="w-100" style=" word-wrap: break-word; overflow-wrap: break-word;overflow:auto;">
                <pre class="small text-muted" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: break-word; word-break: break-word; width: 100%; max-width: 100%; overflow-x: auto;">
                    {{ $exception->getMessage() }}
                </pre>
                <pre class="small text-muted" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: break-word; word-break: break-word; width: 100%; max-width: 100%; overflow-x: auto;">
                    {{ $exception->getTraceAsString() }}
                </pre>
            </div>
        </div>
    @endif
</body>
</html>
