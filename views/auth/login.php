{% extends 'layouts/main.php' %}

{% block title %}Вход{% endblock %}

{% block header %}Вход в систему{% endblock %}

{% block content %}
<form id="login-form">
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div class="form-group">
        <label>Пароль:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Войти</button>
</form>
<script src="/views/assets/js/login.js"></script>
{% endblock %}<?php
