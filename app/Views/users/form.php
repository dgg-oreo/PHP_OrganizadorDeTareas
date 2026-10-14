<?php $isEdit = ! empty($user); ?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= esc($title) ?></h1>
    <p><a href="<?= base_url('users') ?>"><?= lang('Users.back') ?></a></p>

    <?= $this->include('partials/errors') ?>

    <form action="<?= esc($action) ?>" method="post">
        <?= csrf_field() ?>

        <p>
            <label><?= lang('Users.name') ?></label><br>
            <input type="text" name="name" value="<?= esc(set_value('name', $user['name'] ?? '')) ?>" required>
        </p>
        <p>
            <label><?= lang('Users.email') ?></label><br>
            <input type="email" name="email" value="<?= esc(set_value('email', $user['email'] ?? '')) ?>" required>
        </p>
        <p>
            <label><?= lang('Users.password') ?></label><br>
            <input type="password" name="password" <?= $isEdit ? '' : 'required' ?>>
            <?php if ($isEdit): ?><small><?= lang('Users.password_hint') ?></small><?php endif; ?>
        </p>
        <p>
            <label><?= lang('Users.repeat_password') ?></label><br>
            <input type="password" name="password_confirm" <?= $isEdit ? '' : 'required' ?>>
        </p>

        <?php if ($isEdit): ?>
            <p>
                <label>
                    <input type="checkbox" name="active" value="1" <?= $user['active'] ? 'checked' : '' ?> <?= $isSelf ? 'disabled' : '' ?>>
                    <?= lang('Users.active') ?>
                </label>
            </p>
            <p>
                <label>
                    <input type="checkbox" name="is_admin" value="1" <?= $user['is_admin'] ? 'checked' : '' ?> <?= $isSelf ? 'disabled' : '' ?>>
                    <?= lang('Users.administrator') ?>
                </label>
            </p>
        <?php endif; ?>

        <button type="submit" class="btn btn-green"><?= lang('Users.save') ?></button>
        <a class="btn btn-red" href="<?= base_url('users') ?>"><?= lang('Users.cancel') ?></a>
    </form>
<?= $this->endSection() ?>