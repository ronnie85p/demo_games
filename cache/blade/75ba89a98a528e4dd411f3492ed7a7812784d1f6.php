<div class="row mb-4">
    <div class="col">
        <a class="btn btn-light" href="#" onclick="event.preventDefault(); window.history.back()"> 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
            </svg> Назад</a>
        <a class="btn btn-light" href="/games/list">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg> Игры</a>
        <a class="btn btn-light" href="/games/create">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg> Добавить
        </a>
    </div>
</div>

<h1 class="h4">Игра - <small class="text-muted">редактирование</small></h1>
<hr />

<form class="needs-validation" method="POST" novalidate>
    <div class="row mb-2">
        <div class="col-2">
            Название
        </div>
        <div class="col">
            <input class="form-control<?php echo e($errors['name'] ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e($data['name']); ?>" autocomplete="off" />
            <small class="invalid-feedback">
                <?php echo e($errors['name']); ?>

            </small>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-2">
            Описание
        </div>
        <div class="col">
            <textarea class="form-control<?php echo e($errors['description'] ? ' is-invalid' : ''); ?>" name="description"><?php echo e($data['description']); ?></textarea>
            <small class="invalid-feedback">
                <?php echo e($errors['description']); ?>

            </small>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-2">
            Жанр
        </div>
        <div class="col">
            <select class="form-control<?php echo e($errors['genre'] ? ' is-invalid' : ''); ?>" name="genre_id">
                <?php $__currentLoopData = $genres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($g->id); ?>"<?php echo e($data['genre_id'] == $g->id ? ' selected' : ''); ?>><?php echo e($g->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <small class="invalid-feedback">
                <?php echo e($errors['genre']); ?>

            </small>
        </div>
    </div>

    <div class="row">
        <div class="col-2">
            Автор
        </div>
        <div class="col">
            <input class="form-control<?php echo e($errors['author'] ? ' is-invalid' : ''); ?>" name="author" value="<?php echo e($data['author']); ?>" autocomplete="off" />
            <small class="invalid-feedback">
                <?php echo e($errors['author']); ?>

            </small>
        </div>
    </div>
    <hr />
    <button class="btn btn-primary">Сохранить</button>
</form><?php /**PATH /var/www/html/views/games/edit.blade.php ENDPATH**/ ?>