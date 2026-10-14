<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Profile.confirm_title') ?></h1>
    <?= $this->include('partials/errors') ?>

    <form action="<?= base_url('profile/confirm') ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label><?= lang('Profile.password') ?></label><br>
            <input type="password" name="password" required>
        </p>
        <button type="submit" class="btn btn-green"><?= lang('Profile.send') ?></button>
        <a class="btn btn-red" href="<?= base_url('profile') ?>"><?= lang('Profile.cancel') ?></a>
    </form>
<?= $this->endSection() ?>