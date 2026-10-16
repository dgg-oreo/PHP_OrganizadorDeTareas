<?php
$session  = session();
$loggedIn = $session->get('logged_in');
?>
<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PENDI</title>


<style>
body { font-family: Arial, sans-serif; margin: 0; background: #F3F4F4; color: #2C2C2C; }

nav { display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; background: #fff; border-bottom: 2px solid #612D53; padding: 14px 30px; font-family: "Didot", "Bodoni MT", "Playfair Display", Georgia, serif; }
nav .izq { text-align: left; }
nav .der { text-align: right; }
nav a { color: #2C2C2C; text-decoration: none; text-transform: uppercase; letter-spacing: 2px; font-size: 13px; margin: 0 10px; }
nav a:hover { color: #853953; }
nav span { color: #612D53; font-style: italic; font-size: 15px; margin: 0 10px; }
nav a.marca { font-size: 32px; font-weight: bold; letter-spacing: 8px; margin: 0; }

nav a.boton { background: #853953; color: #fff; padding: 8px 18px; }
nav a.boton:hover { background: #612D53; color: #fff; }
nav a.boton-borde { border: 1px solid #853953; color: #853953; padding: 7px 18px; }
nav a.boton-borde:hover { background: #853953; color: #fff; }

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
<div class="izq">
<a href="<?= base_url('/') ?>"><?= lang('App.home') ?></a>
<a href="<?= base_url('lang/en') ?>"><?= lang('App.english') ?></a>
<a href="<?= base_url('lang/es') ?>"><?= lang('App.spanish') ?></a>
</div>

<a class="marca" href="<?= base_url('/') ?>">PENDI</a>

<div class="der">
<?php if ($loggedIn): ?>
<span><?= lang('App.hello', [esc($session->get('user_name'))]) ?></span>
<a href="<?= base_url('profile') ?>"><?= lang('App.profile') ?></a>
<?php if ($session->get('is_admin')): ?>
<a href="<?= base_url('users') ?>"><?= lang('App.users') ?></a>
<?php endif; ?>
<a href="<?= base_url('tasks') ?>"><?= lang('App.tasks') ?></a>
<a href="<?= base_url('logout') ?>"><?= lang('App.logout') ?></a>
<?php else: ?>
<a class="boton" href="<?= base_url('signup') ?>"><?= lang('App.signup') ?></a>
<a class="boton-borde" href="<?= base_url('login') ?>"><?= lang('App.login') ?></a>
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