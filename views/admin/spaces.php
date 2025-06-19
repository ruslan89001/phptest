{% extends 'layouts/main.php' %}

{% block title %}Администрирование пространств{% endblock %}

{% block header %}Управление пространствами{% endblock %}

{% block navigation %}
<li><a href="/admin/users">Пользователи</a></li>
<li><a href="/admin/spaces">Пространства</a></li>
<li><a href="/admin/bookings">Бронирования</a></li>
<li><a href="/profile">Профиль</a></li>
<li><a href="/logout">Выход</a></li>
{% endblock %}

{% block content %}
<button onclick="showAddSpaceForm()">Добавить пространство</button>

<table class="admin-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Цена</th>
        <th>Доступность</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    {% for space in spaces %}
    <tr>
        <td>{{ space.id }}</td>
        <td>{{ space.name }}</td>
        <td>{{ space.price }}</td>
        <td>{{ space.availability ? 'Доступно' : 'Недоступно' }}</td>
        <td>
            <button onclick="editSpace({{ space.id }})">Редактировать</button>
            <button onclick="deleteSpace({{ space.id }})">Удалить</button>
        </td>
    </tr>
    {% endfor %}
    </tbody>
</table>

<div id="space-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="space-form" enctype="multipart/form-data">
            <input type="hidden" name="id" id="space-id">
            <div class="form-group">
                <label>Название:</label>
                <input type="text" name="name" id="space-name" required>
            </div>
            <div class="form-group">
                <label>Описание:</label>
                <textarea name="description" id="space-description" required></textarea>
            </div>
            <div class="form-group">
                <label>Цена:</label>
                <input type="number" step="0.01" name="price" id="space-price" required>
            </div>
            <div class="form-group">
                <label>Локация:</label>
                <input type="text" name="location" id="space-location" required>
            </div>
            <div class="form-group">
                <label>Доступность:</label>
                <select name="availability" id="space-availability">
                    <option value="1">Доступно</option>
                    <option value="0">Недоступно</option>
                </select>
            </div>
            <div class="form-group">
                <label>Изображение:</label>
                <input type="file" name="image" id="space-image">
            </div>
            <button type="submit">Сохранить</button>
        </form>
    </div>
</div>
<script src="/assets/js/admin-spaces.js"></script>
{% endblock %}