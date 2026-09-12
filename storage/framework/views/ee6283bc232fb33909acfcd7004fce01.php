<?php $__env->startSection('title', 'Staff Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="auth-wrap">
    <section class="card auth-card">
        <div class="eyebrow">STAFF PORTAL</div>
        <h1>Administrator Login</h1>
        <p class="muted">Sign in with an authorized SB Secretary account.</p>

        <form method="POST" action="<?php echo e(route('login.store')); ?>" class="stack-form">
            <?php echo csrf_field(); ?>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?php echo e(old('email')); ?>" autocomplete="username" required autofocus>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>

            <label class="checkbox-row">
                <input type="checkbox" name="remember" value="1">
                <span>Remember me</span>
            </label>

            <button class="btn btn-primary btn-block" type="submit">Sign in</button>
        </form>

        <p class="small muted mt-16">For first-time setup, use the admin credentials configured in your local <code>.env</code> file, then change them before deployment.</p>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Capstone\resources\views/auth/login.blade.php ENDPATH**/ ?>