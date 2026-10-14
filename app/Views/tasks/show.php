<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Tasks.detail_title') ?></h1>
    <p><a href="<?= base_url('tasks') ?>"><?= lang('Tasks.back') ?></a></p>

    <p><strong><?= lang('Tasks.id') ?></strong><br><?= (int) $task['id'] ?></p>
    <p><strong><?= lang('Tasks.description') ?></strong><br><?= nl2br(esc($task['description'])) ?></p>
    <p><strong><?= lang('Tasks.created_at') ?></strong><br><?= esc($task['created_at']) ?></p>
    <p><strong><?= lang('Tasks.updated_at') ?></strong><br><?= esc($task['updated_at']) ?></p>

    <div style="display:flex; gap:10px; align-items:center;">
        <a class="btn btn-blue" href="<?= base_url('tasks/' . $task['id'] . '/edit') ?>"><?= lang('Tasks.edit') ?></a>

        <form action="<?= base_url('tasks/' . $task['id'] . '/delete') ?>" method="post"
              onsubmit='return confirm(<?= json_encode(lang('Tasks.confirm_delete'), JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-red"><?= lang('Tasks.delete') ?></button>
        </form>
    </div>
<?= $this->endSection() ?>