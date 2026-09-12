<?php $__env->startSection('title', 'Admin Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="card narrow-card" style="max-width: 400px; margin: 4rem auto;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <div class="eyebrow">AUTHENTICATION</div>
        <h1>Admin Login</h1>
        <p class="muted">Sign in to access the administrator panel.</p>
    </div>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="field" style="margin-bottom: 1.25rem;">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="email">
        </div>

        <div class="field" style="margin-bottom: 1.5rem;">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
        </div>

        <button type="submit" class="btn btn-primary btn-block" style="width: 100%;">Sign In</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/auth/login.blade.php ENDPATH**/ ?>