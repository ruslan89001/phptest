{% extends 'layouts/main.php' %}

{% block title %}Администрирование бронирований{% endblock %}

{% block header %}Управление бронированиями{% endblock %}

{% block navigation %}
<li><a href="/admin/users">Пользователи</a></li>
<li><a href="/admin/spaces">Пространства</a></li>
<li><a href="/admin/bookings">Бронирования</a></li>
<li><a href="/profile">Профиль</a></li>
<li><a href="/logout">Выход</a></li>
{% endblock %}

{% block content %}
<table class="admin-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Пользователь</th>
        <th>Пространство</th>
        <th>Дата начала</th>
        <th>Дата окончания</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    {% for booking in bookings %}
    <tr>
        <td>{{ booking.id }}</td>
        <td>{{ booking.user.username }}</td>
        <td>{{ booking.space.name }}</td>
        <td>{{ booking.start_time }}</td>
        <td>{{ booking.end_time }}</td>
        <td>
            <select onchange="updateBookingStatus({{ booking.id }}, this.value)">
                <option value="pending" {{ booking.status == 'pending' ? 'selected' : '' }}>Ожидание</option>
                <option value="confirmed" {{ booking.status == 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                <option value="cancelled" {{ booking.status == 'cancelled' ? 'selected' : '' }}>Отменено</option>
            </select>
        </td>
        <td>
            <button onclick="deleteBooking({{ booking.id }})">Удалить</button>
        </td>
    </tr>
    {% endfor %}
    </tbody>
</table>
<script src="/assets/js/admin-bookings.js"></script>
{% endblock %}