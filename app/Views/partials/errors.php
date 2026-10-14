<?php if (! empty($errors)): ?>
    <div class="alert alert-error">
        <ul style="margin:0; padding-left:18px;">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>