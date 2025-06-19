<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{% yield title %}</title>
    <link rel="stylesheet" href="/views/assets/css/styles.css">
</head>
<body>
<header>
    <h1>{% yield header %}</h1>
    <nav>
        <ul>
            {% yield navigation %}
        </ul>
    </nav>
</header>
<main>
    {% yield content %}
</main>
<footer>
    <p>&copy; 2025 Coworking Booking</p>
</footer>
<script src="/views/assets/js/main.js"></script>
</body>
</html>