<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'SB Secretary Portal'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <div>
            <a class="brand" href="<?php echo e(route('home')); ?>">SB Secretary Portal</a>
            <span class="brand-subtitle">Bontoc Sangguniang Bayan Archives</span>
        </div>
        <nav class="top-nav" aria-label="Primary navigation">
            <a href="<?php echo e(route('home')); ?>">Public Archive</a>
            <a href="<?php echo e(route('public.requests.create')); ?>">Request Copy</a>
            <a href="<?php echo e(route('public.requests.track')); ?>">Track Request</a>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container page-content">
    <?php if(session('success')): ?>
        <div class="alert alert-success" role="status"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('status')): ?>
        <div class="alert alert-info" role="status"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error" role="alert">
            <strong>Please correct the following:</strong>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
</main>

<footer class="site-footer">
    <div class="container">SB Secretary Portal · Official Records Archive</div>
</footer>
</body>
</html>
<?php /**PATH C:\Users\Administrator\Capstone\resources\views/layouts/app.blade.php ENDPATH**/ ?>