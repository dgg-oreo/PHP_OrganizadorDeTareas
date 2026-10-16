<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="tarjeta">
    <h1><?= lang('Auth.login_title') ?></h1>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label><?= lang('Auth.email') ?></label>
            <input type="email" name="email" value="<?= esc(set_value('email')) ?>" required>
        </p>
        <p>
            <label><?= lang('Auth.password') ?></label>
            <input type="password" name="password" required>
        </p>
        <p>
            <label class="check">
                <input type="checkbox" name="remember" value="1">
                <?= lang('Auth.remember_me') ?>
            </label>
        </p>

        <button type="submit" class="btn btn-green"><?= lang('Auth.login_button') ?></button>
        <a href="<?= base_url('forgot-password') ?>" style="margin-left:12px; font-size:14px;"><?= lang('Auth.forgot_password') ?></a>
    </form>
</div>
<?= $this->endSection() ?>