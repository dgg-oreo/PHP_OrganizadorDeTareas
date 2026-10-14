<?php
$session  = session();
$loggedIn = $session->get('logged_in');
?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Organizador de Tareas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f7fa; }
        nav { display: flex; justify-content: space-between; background: #2c3e50; padding: 12px 20px; }
        nav a { color: #fff; text-decoration: none; margin-right: 14px; }
        nav a:hover { text-decoration: underline; }
        nav span { color: #fff; margin-right: 14px; }
        main { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .alert { padding: 10px 14px; border-radius: 4px; margin-bottom: 16px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-error { background: #f8d7da; color: #721c24; }
        .btn { display:inline-block; padding:8px 16px; border:0; border-radius:4px; color:#fff; text-decoration:none; cursor:pointer; font-size:14px; }
        .btn-green { background:#28a745; }
        .btn-red { background:#dc3545; }
        .btn-blue { background:#0d6efd; }
input[type=text], input[type=email], input[type=password], input[type=file] { width:100%; padding:8px; box-sizing:border-box; }
    </style>
</head>
<body>
    <nav>
        <div>
            <a href="<?= base_url('/') ?>"><?= lang('App.home') ?></a>
            <a href="<?= base_url('lang/en') ?>"><?= lang('App.english') ?></a>
            <a href="<?= base_url('lang/es') ?>"><?= lang('App.spanish') ?></a>
        </div>
        <div>
            <?php if ($loggedIn): ?>
                <span><?= lang('App.hello', [esc($session->get('user_name'))]) ?></span>
                <a href="<?= base_url('profile') ?>"><?= lang('App.profile') ?></a>
                <?php if ($session->get('is_admin')): ?>
                    <a href="<?= base_url('users') ?>"><?= lang('App.users') ?></a>
                <?php endif; ?>
                <a href="<?= base_url('tasks') ?>"><?= lang('App.tasks') ?></a>
                <a href="<?= base_url('logout') ?>"><?= lang('App.logout') ?></a>
            <?php else: ?>
                <a href="<?= base_url('signup') ?>"><?= lang('App.signup') ?></a>
                <a href="<?= base_url('login') ?>"><?= lang('App.login') ?></a>
            <?php endif; ?>
        </div>
    </nav>

    <main>
        <?php if ($msg = $session->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= esc($msg) ?></div>
        <?php endif; ?>
        <?php if ($msg = $session->getFlashdata('error')): ?>
            <div class="alert alert-error"><?= esc($msg) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>