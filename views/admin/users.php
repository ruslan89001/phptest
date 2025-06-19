{% extends 'layouts/main.php' %}

{% block title %}Администрирование пользователей{% endblock %}

{% block header %}Управление пользователями{% endblock %}

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
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    {% for user in users %}
    <tr>
        <td>{{ user.id }}</td>
        <td>{{ user.username }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.role }}</td>
        <td>
            <button onclick="editUser({{ user.id }})">Редактировать</button>
            <button onclick="deleteUser({{ user.id }})">Удалить</button>
        </td>
    </tr>
    {% endfor %}
    </tbody>
</table>

<div id="edit-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="user-edit-form">
            <input type="hidden" name="id" id="edit-user-id">
            <div class="form-group">
                <label>Имя пользователя:</label>
                <label for="edit-username"></label><input type="text" name="username" id="edit-username" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <label for="edit-email"></label><input type="email" name="email" id="edit-email" required>
            </div>
            <div class="form-group">
                <label>Роль:</label>
                <label for="edit-role"></label><select name="role" id="edit-role">
                    <option value="user">Пользователь</option>
                    <option value="admin">Администратор</option>
                </select>
            </div>
            <button type="submit">Сохранить</button>
        </form>
    </div>
</div>
<script src="/views/assets/js/admin-users.js"></script>
{% endblock %}