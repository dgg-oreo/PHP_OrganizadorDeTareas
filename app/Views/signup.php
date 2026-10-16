<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="tarjeta">
    <h1><?= lang('Auth.signup_title') ?></h1>

    <?php if (! empty($errors)): ?>
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:18px;">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('signup') ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label><?= lang('Auth.name') ?></label>
            <input type="text" name="name" value="<?= esc(set_value('name')) ?>" required>
        </p>
        <p>
            <label><?= lang('Auth.email') ?></label>
            <input type="email" name="email" value="<?= esc(set_value('email')) ?>" required>
        </p>
        <p>
            <label><?= lang('Auth.password') ?></label>
            <input type="password" name="password" required>
        </p>
        <p>
            <label><?= lang('Auth.repeat_password') ?></label>
            <input type="password" name="password_confirm" required>
        </p>

        <button type="submit" class="btn btn-green"><?= lang('Auth.signup_button') ?></button>
        <a href="<?= base_url('/') ?>" class="btn btn-red"><?= lang('Auth.cancel') ?></a>
    </form>
</div>
<?= $this->endSection() ?>