{% extends 'layouts/main.php' %}

{% block title %}Профиль{% endblock %}

{% block header %}Профиль пользователя{% endblock %}

{% block navigation %}
{% if user.role == 'admin' %}
<li><a href="/admin/users">Пользователи</a></li>
<li><a href="/admin/spaces">Пространства</a></li>
<li><a href="/admin/bookings">Бронирования</a></li>
{% else %}
<li><a href="/spaces">Пространства</a></li>
<li><a href="/bookings">Мои бронирования</a></li>
<li><a href="/reviews">Отзывы</a></li>
{% endif %}
<li><a href="/logout">Выход</a></li>
{% endblock %}

{% block content %}
<div class="profile-info">
    <h3>{{ user.username }}</h3>
    <p>Email: {{ user.email }}</p>
    <p>Роль: {{ user.role }}</p>
</div>

<form id="profile-form">
    <h3>Изменить данные</h3>
    <div class="form-group">
        <label>Имя пользователя:</label>
        <input type="text" name="username" value="{{ user.username }}" required>
    </div>
    <div class="form-group">
        <label>Email:</label>
        <input type="email" name="email" value="{{ user.email }}" required>
    </div>
    <div class="form-group">
        <label>Новый пароль (оставьте пустым, если не меняется):</label>
        <input type="password" name="new_password">
    </div>
    <button type="submit">Сохранить</button>
</form>
<script src="/assets/js/profile.js"></script>
{% endblock %}