<?php $this->layout('layouts/main', ['title' => 'Коворкинг-пространства']) ?>

<div class="container mt-4">
  <?php if (app()->isAdmin()): ?>
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Управление пространствами</h1>
    <a href="/admin/spaces/create" class="btn btn-primary">
      <i class="bi bi-plus-circle"></i> Добавить пространство
    </a>
  </div>
  <?php else: ?>
  <h1 class="mb-4">Доступные коворкинг-пространства</h1>
  <?php endif; ?>

  <?php if (session()->hasFlash('success')): ?>
  <div class="alert alert-success"><?= session()->getFlash('success') ?></div>
  <?php endif; ?>

  <?php if (session()->hasFlash('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlash('error') ?></div>
  <?php endif; ?>

  <div class="row">
    <?php foreach ($spaces as $space): ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100">
        <?php if ($space->image): ?>
        <img src="/assets/images/<?= $space->image ?>" class="card-img-top" alt="<?= $space->name ?>">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?= $space->name ?></h5>
          <p class="card-text"><?= substr($space->description, 0, 100) ?>...</p>
          <p class="text-muted"><?= $space->location ?></p>
          <div class="d-flex justify-content-between align-items-center">
            <span class="h5"><?= $space->getFormattedPrice() ?></span>
            <span><?= $space->getStatusBadge() ?></span>
          </div>
        </div>
        <div class="card-footer">
          <a href="/spaces/<?= $space->id ?>" class="btn btn-outline-primary">
            Подробнее
          </a>
          <?php if (app()->isAdmin()): ?>
          <div class="mt-2 d-flex gap-2">
            <a href="/admin/spaces/<?= $space->id ?>/edit" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil"></i> Редактировать
            </a>
            <form action="/admin/spaces/<?= $space->id ?>/delete" method="post">
              <button type="submit" class="btn btn-sm btn-danger"
                      onclick="return confirm('Удалить пространство?')">
                <i class="bi bi-trash"></i> Удалить
              </button>
            </form>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>