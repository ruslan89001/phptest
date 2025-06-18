<?php $this->layout('layouts/main', ['title' => 'Вход в систему']) ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Вход в систему</h3>
        </div>
        <div class="card-body">
          <?php if ($this->session->hasFlash('error')): ?>
          <div class="alert alert-danger"><?= $this->session->getFlash('error') ?></div>
          <?php endif; ?>

          <form method="post" action="/login">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Пароль</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Войти</button>
          </form>

          <div class="mt-3 text-center">
            <p>Ещё нет аккаунта? <a href="/register">Зарегистрируйтесь</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>