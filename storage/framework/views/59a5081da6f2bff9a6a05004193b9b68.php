<?php $__env->startSection('title', 'Request Submitted'); ?>

<?php $__env->startSection('content'); ?>
<section class="hero card">
    <div>
        <div class="eyebrow">REQUEST RECEIVED</div>
        <h1>Your request has been submitted</h1>
        <p class="muted">We will notify you via SMS once your certified copy is ready for pickup.</p>
    </div>
</section>

<section class="card narrow-card">
    <div class="details-list">
        <div class="detail-item">
            <span class="muted">Document</span>
            <strong><?php echo e($request->document->session_name ?? $request->document_id); ?></strong>
        </div>
        <div class="detail-item">
            <span class="muted">Copies</span>
            <strong><?php echo e($request->copies); ?></strong>
        </div>
        <div class="detail-item">
            <span class="muted">Pickup Date</span>
            <strong><?php echo e(\Carbon\Carbon::parse($request->pickup_date)->format('F d, Y')); ?></strong>
        </div>
        <div class="detail-item">
            <span class="muted">Status</span>
            <strong><span class="badge badge-warning"><?php echo e($request->status); ?></span></strong>
        </div>
    </div>

    <div class="actions-end" style="margin-top: 2rem;">
        <a class="btn btn-primary btn-block" href="<?php echo e(route('home')); ?>">Back to Archive</a>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/public/requests/success.blade.php ENDPATH**/ ?>