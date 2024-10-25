<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Default Title' }}</title>
</head>
<body>
    <header>
        <!-- Header content -->
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <!-- Footer content -->
    </footer>
</body>
</html>
