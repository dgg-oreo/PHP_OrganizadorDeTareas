<?php
$pageUrl = static function (int $p) use ($q): string {
    $params = ['page' => $p];
    if ($q !== '') {
        $params['q'] = $q;
    }
    return base_url('tasks') . '?' . http_build_query($params);
};
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <h1><?= lang('Tasks.title') ?></h1>

    <p><a class="btn btn-blue" href="<?= base_url('tasks/new') ?>"><?= lang('Tasks.new_task') ?></a></p>

    <form id="searchForm" action="<?= base_url('tasks') ?>" method="get" style="display:flex; gap:8px; margin-bottom:16px;">
        <label for="q" style="align-self:center;"><?= lang('Tasks.search') ?></label>
        <input type="text" id="q" name="q" value="<?= esc($q) ?>" style="max-width:320px;">
        <button type="submit" class="btn btn-blue"><?= lang('Tasks.search_button') ?></button>
    </form>

    <?php if (empty($tasks)): ?>
        <p><?= lang('Tasks.no_tasks') ?></p>
    <?php else: ?>
        <ul style="list-style:none; padding:0;">
            <?php foreach ($tasks as $t): ?>
                <li style="padding:8px 0; border-bottom:1px solid #ddd;">
                    <a href="<?= base_url('tasks/' . $t['id']) ?>">
                        <?= esc(mb_strimwidth($t['description'], 0, 90, '...')) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p style="margin-top:16px;">
        <?php if ($page > 1): ?>
            <a class="btn btn-blue" href="<?= esc($pageUrl($page - 1)) ?>"><?= lang('Tasks.newer') ?></a>
        <?php endif; ?>
        <?php if ($page < $pages): ?>
            <a class="btn btn-blue" href="<?= esc($pageUrl($page + 1)) ?>"><?= lang('Tasks.older') ?></a>
        <?php endif; ?>
    </p>

    <script>
        // Filtrado dinámico: busca solo, medio segundo después de dejar de escribir
        (function () {
            var input = document.getElementById('q');
            var form  = document.getElementById('searchForm');
            var timer;
            if (new URLSearchParams(location.search).has('q')) {
                input.focus();
                input.setSelectionRange(input.value.length, input.value.length);
            }
            input.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () { form.submit(); }, 500);
            });
        })();
    </script>
<?= $this->endSection() ?>