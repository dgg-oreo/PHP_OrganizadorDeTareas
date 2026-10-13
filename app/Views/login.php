<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
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
            <label><?= lang('Auth.email') ?></label><br>
            <input type="email" name="email" value="<?= esc(set_value('email')) ?>" required style="width:100%; padding:8px;">
        </p>
        <p>
            <label><?= lang('Auth.password') ?></label><br>
            <input type="password" name="password" required style="width:100%; padding:8px;">
        </p>
        <p>
            <label>
                <input type="checkbox" name="remember" value="1">
                <?= lang('Auth.remember_me') ?>
            </label>
        </p>

        <button type="submit" style="padding:8px 16px; background:#28a745; color:#fff; border:0; border-radius:4px;">
            <?= lang('Auth.login_button') ?>
        </button>
        <a href="<?= base_url('forgot-password') ?>"><?= lang('Auth.forgot_password') ?></a>
    </form>
<?= $this->endSection() ?>