<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Users.detail_title') ?></h1>
    <p><a href="<?= base_url('users') ?>"><?= lang('Users.back') ?></a></p>

    <p><strong><?= lang('Users.name') ?></strong><br><?= esc($user['name']) ?></p>
    <p><strong><?= lang('Users.email') ?></strong><br><?= esc($user['email']) ?></p>
    <p><strong><?= lang('Users.active') ?></strong><br><?= $user['active'] ? lang('Users.yes') : lang('Users.no') ?></p>
    <p><strong><?= lang('Users.administrator') ?></strong><br><?= $user['is_admin'] ? lang('Users.yes') : lang('Users.no') ?></p>
    <p><strong><?= lang('Users.created_at') ?></strong><br><?= esc($user['created_at']) ?></p>
    <p><strong><?= lang('Users.updated_at') ?></strong><br><?= esc($user['updated_at']) ?></p>

    <div style="display:flex; gap:10px; align-items:center;">
        <a class="btn btn-blue" href="<?= base_url('users/' . $user['id'] . '/edit') ?>"><?= lang('Users.edit') ?></a>

        <?php if (! $isSelf): ?>
            <form action="<?= base_url('users/' . $user['id'] . '/delete') ?>" method="post"
                  onsubmit='return confirm(<?= json_encode(lang('Users.confirm_delete'), JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-red"><?= lang('Users.delete') ?></button>
            </form>
        <?php endif; ?>
    </div>
<?= $this->endSection() ?>