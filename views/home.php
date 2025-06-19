{% extends 'layouts/main.php' %}

{% block title %}Coworking Booking{% endblock %}

{% block header %}Добро пожаловать в Coworking Booking{% endblock %}

{% block navigation %}
<li><a href="/register">Регистрация</a></li>
<li><a href="/login">Вход</a></li>
{% endblock %}

{% block content %}
<p>Здесь вы можете забронировать место в коворкинге, оставить отзывы и управлять своими бронированиями.</p>
<div id="featured-spaces"></div>
<script src="/assets/js/home.js"></script>
{% endblock %}