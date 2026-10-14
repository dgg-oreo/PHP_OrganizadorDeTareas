<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Users.title') ?></h1>

    <p><a class="btn btn-blue" href="<?= base_url('users/new') ?>"><?= lang('Users.new_user') ?></a></p>

    <div style="overflow-x:auto;">
    <table style="width:100%; border-collapse:collapse; background:#fff;">
        <thead>
            <tr style="text-align:left; border-bottom:2px solid #333;">
                <th style="padding:8px;"><?= lang('Users.name') ?></th>
                <th style="padding:8px;"><?= lang('Users.email') ?></th>
                <th style="padding:8px;"><?= lang('Users.active') ?></th>
                <th style="padding:8px;"><?= lang('Users.administrator') ?></th>
                <th style="padding:8px;"><?= lang('Users.created_at') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr><td colspan="5" style="padding:8px;"><?= lang('Users.no_users') ?></td></tr>
            <?php endif; ?>
            <?php foreach ($users as $u): ?>
                <tr style="border-bottom:1px solid #ddd;">
                    <td style="padding:8px;"><a href="<?= base_url('users/' . $u['id']) ?>"><?= esc($u['name']) ?></a></td>
                    <td style="padding:8px;"><?= esc($u['email']) ?></td>
                    <td style="padding:8px;"><?= $u['active'] ? lang('Users.yes') : lang('Users.no') ?></td>
                    <td style="padding:8px;"><?= $u['is_admin'] ? lang('Users.yes') : lang('Users.no') ?></td>
                    <td style="padding:8px;"><?= esc($u['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>

       <?php
    $current = $pager->getCurrentPage();
    $last    = $pager->getPageCount();
    ?>
    <p style="margin-top:16px;">
        <?php if ($current > 1): ?>
            <a class="btn btn-blue" href="<?= esc($pager->getPageURI($current - 1)) ?>"><?= lang('Users.newer') ?></a>
        <?php endif; ?>
        <?php if ($current < $last): ?>
            <a class="btn btn-blue" href="<?= esc($pager->getPageURI($current + 1)) ?>"><?= lang('Users.older') ?></a>
        <?php endif; ?>
    </p>

   
<?= $this->endSection() ?>