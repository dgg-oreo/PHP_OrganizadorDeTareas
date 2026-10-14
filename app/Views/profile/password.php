<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Profile.password_title') ?></h1>
    <?= $this->include('partials/errors') ?>

    <form action="<?= base_url('profile/password') ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label><?= lang('Profile.current_password') ?></label><br>
            <input type="password" name="current_password" required>
        </p>
        <p>
            <label><?= lang('Profile.new_password') ?></label><br>
            <input type="password" name="new_password" required>
        </p>
        <p>
            <label><?= lang('Profile.repeat_new_password') ?></label><br>
            <input type="password" name="new_confirm" required>
        </p>
        <button type="submit" class="btn btn-green"><?= lang('Profile.save') ?></button>
        <a class="btn btn-red" href="<?= base_url('profile') ?>"><?= lang('Profile.cancel') ?></a>
    </form>
<?= $this->endSection() ?>