{% extends 'layouts/main.php' %}

{% block title %}Отзывы{% endblock %}

{% block header %}Отзывы о пространствах{% endblock %}

{% block navigation %}
<li><a href="/profile">Профиль</a></li>
<li><a href="/spaces">Пространства</a></li>
<li><a href="/bookings">Мои бронирования</a></li>
<li><a href="/logout">Выход</a></li>
{% endblock %}

{% block content %}
<div class="reviews-container">
    <div class="add-review">
        <h3>Оставить отзыв</h3>
        <form id="review-form">
            <label>
                <select name="space_id" required>
                    <option value="">Выберите пространство</option>
                    {% for space in spaces %}
                    <option value="{{ space.id }}">{{ space.name }}</option>
                    {% endfor %}
                </select>
            </label>
            <label>
                <select name="rating" required>
                    <option value="5">5 - Отлично</option>
                    <option value="4">4 - Хорошо</option>
                    <option value="3">3 - Удовлетворительно</option>
                    <option value="2">2 - Плохо</option>
                    <option value="1">1 - Ужасно</option>
                </select>
            </label>
            <label>
                <textarea name="comment" required placeholder="Ваш отзыв"></textarea>
            </label>
            <button type="submit">Отправить</button>
        </form>
    </div>

    <div class="reviews-list">
        <h3>Отзывы пользователей</h3>
        <div id="reviews-content"></div>
    </div>
</div>
<script src="/views/assets/js/reviews.js"></script>
{% endblock %}