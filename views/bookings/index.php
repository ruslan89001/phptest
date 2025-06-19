{% extends 'layouts/main.php' %}

{% block title %}Мои бронирования{% endblock %}

{% block header %}Мои бронирования{% endblock %}

{% block navigation %}
<li><a href="/spaces">Пространства</a></li>
<li><a href="/bookings">Мои бронирования</a></li>
<li><a href="/reviews">Отзывы</a></li>
<li><a href="/logout">Выход</a></li>
{% endblock %}

{% block content %}
<table id="bookings-table">
    <thead>
    <tr>
        <th>Пространство</th>
        <th>Дата начала</th>
        <th>Дата окончания</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>
<script src="/views/assets/js/bookings.js"></script>
{% endblock %}