<?php
$avatar = ! empty($user['avatar'])
    ? base_url('uploads/avatars/' . $user['avatar'])
    : base_url('img/default-avatar.svg');
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Profile.title') ?></h1>

    <img src="<?= esc($avatar) ?>" alt="avatar" width="150" height="150"
         style="object-fit:cover; border:1px solid #ccc; display:block; margin-bottom:10px;">

    <?php if (! empty($user['avatar'])): ?>
        <p><a class="btn btn-red" href="<?= base_url('profile/image/delete') ?>"><?= lang('Profile.delete_image') ?></a></p>
    <?php endif; ?>

    <p><strong><?= lang('Profile.name') ?></strong><br><?= esc($user['name']) ?></p>
    <p><strong><?= lang('Profile.email') ?></strong><br><?= esc($user['email']) ?></p>

    <a class="btn btn-blue" href="<?= base_url('profile/edit') ?>"><?= lang('Profile.edit') ?></a>
    <a class="btn btn-blue" href="<?= base_url('profile/password') ?>"><?= lang('Profile.change_password') ?></a>
    <a class="btn btn-blue" href="<?= base_url('profile/image') ?>"><?= lang('Profile.change_image') ?></a>
<?= $this->endSection() ?>