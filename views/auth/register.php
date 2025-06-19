{% extends 'layouts/main.php' %}

{% block title %}Регистрация{% endblock %}

{% block header %}Регистрация{% endblock %}

{% block content %}
<form id="register-form">
    <div class="form-group">
        <label>Имя пользователя:</label>
        <label>
            <input type="text" name="username" required>
        </label>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <label>
            <input type="email" name="email" required>
        </label>
    </div>
    <div class="form-group">
        <label>Пароль:</label>
        <label>
            <input type="password" name="password" required>
        </label>
    </div>
    <div class="form-group">
        <label>Подтвердите пароль:</label>
        <label>
            <input type="password" name="confirm_password" required>
        </label>
    </div>
    <button type="submit">Зарегистрироваться</button>
</form>
<script src="/views/assets/js/register.js"></script>
{% endblock %}