<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard - SB Portal'); ?></title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <img src="<?php echo e(asset('images/logo.png')); ?>" alt="SB Logo" style="height: 60px; width: auto; display: block;">
            </a>
            <div>
                <a class="brand" href="<?php echo e(route('admin.dashboard')); ?>">SB Portal</a>
                <span class="brand-subtitle">Administrator Portal</span>
            </div>
        </div>
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

<footer class="site-footer" style="text-align: center;">
    <div class="container" style="text-align: center;">SB Portal · Administrator Panel</div>
</footer>
</body>
</html><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/layouts/admin.blade.php ENDPATH**/ ?>