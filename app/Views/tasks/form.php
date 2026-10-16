<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= esc($title) ?></h1>
    <a class="volver" href="<?= base_url('tasks') ?>"><?= lang('Tasks.back') ?></a>

    <?= $this->include('partials/errors') ?>

    <form action="<?= esc($action) ?>" method="post">
        <?= csrf_field() ?>
        <p>
            <label><?= lang('Tasks.description') ?></label><br>
            <input type="text" name="description" maxlength="1000"
                   value="<?= esc(set_value('description', $task['description'] ?? '')) ?>" required>
        </p>
        <button type="submit" class="btn btn-green">
            <?= $task ? lang('Tasks.save') : lang('Tasks.send') ?>
        </button>
        <a class="btn btn-red" href="<?= base_url('tasks') ?>"><?= lang('Tasks.cancel') ?></a>
    </form>
<?= $this->endSection() ?>