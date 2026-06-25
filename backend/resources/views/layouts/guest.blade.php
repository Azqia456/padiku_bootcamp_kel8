<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Masuk' }} - PADIKU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .auth-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            background-color: #fafafa;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 0.9375rem;
            color: #111827;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .auth-input:focus {
            outline: none;
            border-color: #0A5C34;
            box-shadow: 0 0 0 2px rgba(10, 92, 52, 0.15);
        }
        .auth-input.has-suffix { padding-right: 44px; }
        .auth-select {
            width: 100%;
            padding: 14px 16px;
            background-color: #fafafa;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 0.9375rem;
            color: #111827;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
        }
        .auth-select:focus {
            outline: none;
            border-color: #0A5C34;
            box-shadow: 0 0 0 2px rgba(10, 92, 52, 0.15);
        }
        .auth-error { color: #E53935; font-size: 0.8125rem; margin-top: 6px; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f5f5f5] text-gray-900 antialiased min-h-screen">
    <div class="min-h-screen flex items-center justify-center px-6 py-8">
        <div class="w-full max-w-[400px]">
            {{ $slot }}
        </div>
    </div>
    @stack('scripts')
</body>
</html>
