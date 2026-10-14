<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Profile.image_title') ?></h1>
    <?= $this->include('partials/errors') ?>

    <form action="<?= base_url('profile/image') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <p>
            <label><?= lang('Profile.choose_image') ?> (JPG, PNG, WEBP, máx. 2 MB)</label><br>
            <input type="file" name="avatar" accept="image/png,image/jpeg,image/webp" required>
        </p>
        <button type="submit" class="btn btn-green"><?= lang('Profile.save') ?></button>
        <a class="btn btn-red" href="<?= base_url('profile') ?>"><?= lang('Profile.cancel') ?></a>
    </form>
<?= $this->endSection() ?>