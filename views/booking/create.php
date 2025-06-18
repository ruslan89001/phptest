<?php $this->layout('layouts/main', ['title' => 'Бронирование пространства']) ?>

<div class="container mt-5">
  <h1 class="mb-4">Бронирование: <?= $space->name ?></h1>

  <div class="row">
    <div class="col-md-8">
      <form method="post" action="/spaces/<?= $space->id ?>/book">
        <div class="mb-3">
          <label for="start_time" class="form-label">Дата и время начала</label>
          <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
        </div>

        <div class="mb-3">
          <label for="end_time" class="form-label">Дата и время окончания</label>
          <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
        </div>

        <div class="mb-3">
          <label for="notes" class="form-label">Дополнительные пожелания</label>
          <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Забронировать</button>
        <a href="/spaces/<?= $space->id ?>" class="btn btn-secondary">Отмена</a>
      </form>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Информация о пространстве</h5>
          <p class="card-text"><?= $space->description ?></p>
          <p class="card-text"><strong>Локация:</strong> <?= $space->location ?></p>
          <p class="card-text"><strong>Цена:</strong> <?= number_format($space->price, 2) ?> ₽/час</p>
          <p class="card-text"><strong>Статус:</strong>
            <span class="badge bg-<?= $space->availability ? 'success' : 'danger' ?>">
                            <?= $space->availability ? 'Доступно' : 'Недоступно' ?>
                        </span>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>