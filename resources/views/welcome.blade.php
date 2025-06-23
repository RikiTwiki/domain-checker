<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Domain Checker</title>
    @vite(['resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div id="app"></div>
</body>
</html>
