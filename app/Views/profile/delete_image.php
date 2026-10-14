<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Profile.delete_title') ?></h1>
    <p><?= lang('Profile.are_you_sure') ?></p>

    <form action="<?= base_url('profile/image/delete') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-green"><?= lang('Profile.save') ?></button>
        <a class="btn btn-red" href="<?= base_url('profile') ?>"><?= lang('Profile.cancel') ?></a>
    </form>
<?= $this->endSection() ?>