<?php class_exists('app\core\Template') or exit; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Coworking Booking') ?></title>
    <link rel="stylesheet" href="/views/assets/css/styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="/">Главная</a></li>
            <?php if (isset($user)): ?>
                <li><a href="/logout">Выход</a></li>
            <?php else: ?>
                <li><a href="/login">Вход</a></li>
                <li><a href="/register">Регистрация</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header><!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Coworking Booking' ?></title>
    <link rel="stylesheet" href="/views/assets/css/styles.css">
</head>
<body>
<header>
    <h1>Coworking Booking</h1>
    <nav>
        <ul>
            <li><a href="/">Главная</a></li>
            <?php if (isset($user)): ?>
                <li><a href="/profile">Профиль</a></li>
                <li><a href="/logout">Выход</a></li>
            <?php else: ?>
                <li><a href="/login">Вход</a></li>
                <li><a href="/register">Регистрация</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
    <?= $content ?? "" ?>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Coworking Booking</p>
</footer>
</body>
</html>

<main>
    <?= $content ?? '' ?>
</main>

<footer>
    <p>&copy; <?= date('Y') ?> Coworking Booking</p>
</footer>
</body>
</html>



