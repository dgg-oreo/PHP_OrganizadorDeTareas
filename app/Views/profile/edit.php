<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Profile.edit_title') ?></h1>
    <?= $this->include('partials/errors') ?>

    <form action="<?= base_url('profile/edit') ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label><?= lang('Profile.name') ?></label><br>
            <input type="text" name="name" value="<?= esc(set_value('name', $user['name'])) ?>" required>
        </p>
        <p>
            <label><?= lang('Profile.email') ?></label><br>
            <input type="email" name="email" value="<?= esc(set_value('email', $user['email'])) ?>" required>
        </p>
        <button type="submit" class="btn btn-green"><?= lang('Profile.save') ?></button>
        <a class="btn btn-red" href="<?= base_url('profile') ?>"><?= lang('Profile.cancel') ?></a>
    </form>
<?= $this->endSection() ?>