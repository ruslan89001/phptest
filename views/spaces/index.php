{% extends 'layouts/main.php' %}

{% block title %}Пространства{% endblock %}

{% block header %}Доступные пространства{% endblock %}

{% block navigation %}
<li><a href="/profile">Профиль</a></li>
<li><a href="/bookings">Мои бронирования</a></li>
<li><a href="/reviews">Отзывы</a></li>
<li><a href="/logout">Выход</a></li>
{% endblock %}

{% block content %}
<div id="spaces-container" class="spaces-grid"></div>
<script src="/views/assets/js/spaces.js"></script>
{% endblock %}