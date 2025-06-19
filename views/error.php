{% extends 'layouts/main.php' %}

{% block title %}Ошибка {{ code }}{% endblock %}

{% block content %}
<div class="error-page">
    <h1>Ошибка {{ code }}</h1>
    <p>{{ message }}</p>
    <a href="/" class="btn">На главную</a>
</div>
{% endblock %}