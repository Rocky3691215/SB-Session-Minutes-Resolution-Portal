<?php $__env->startSection('title', 'Track Request'); ?>

<?php $__env->startSection('content'); ?>
<section class="card narrow-card">
    <div class="eyebrow">REQUEST TRACKING</div>
    <h1>Track a Certified Copy Request</h1>
    <p class="muted">For privacy, both your tracking code and contact number are required.</p>

    <form method="POST" action="<?php echo e(route('public.requests.track.search')); ?>" class="stack-form">
        <?php echo csrf_field(); ?>
        <label for="tracking_code">Tracking Code</label>
        <input id="tracking_code" name="tracking_code" value="<?php echo e(old('tracking_code')); ?>" placeholder="REQ-XXXXXXXX" required maxlength="20">

        <label for="contact_number">Contact Number</label>
        <input id="contact_number" name="contact_number" value="<?php echo e(old('contact_number')); ?>" required maxlength="50">

        <button class="btn btn-primary" type="submit">Check Status</button>
    </form>

    <?php if(isset($searched)): ?>
        <div class="track-result mt-24">
            <?php if($record): ?>
                <div class="alert alert-success">Request found.</div>
                <dl class="summary-list">
                    <div><dt>Tracking Code</dt><dd><?php echo e($record->tracking_code); ?></dd></div>
                    <div><dt>Document</dt><dd><?php echo e($record->document->document_number); ?> — <?php echo e($record->document->title); ?></dd></div>
                    <div><dt>Copies</dt><dd><?php echo e($record->copies); ?></dd></div>
                    <div><dt>Pickup Date</dt><dd><?php echo e($record->pickup_date->format('F d, Y')); ?></dd></div>
                    <div><dt>Status</dt><dd><span class="badge <?php echo e(str_replace(' ', '-', strtolower($record->status)) === 'ready-for-pickup' ? 'badge-ready' : (strtolower($record->status) === 'completed' ? 'badge-completed' : (strtolower($record->status) === 'cancelled' ? 'badge-cancelled' : 'badge-pending'))); ?>"><?php echo e($record->status); ?></span></dd></div>
                    <?php if($record->notes): ?><div><dt>Notes</dt><dd><?php echo e($record->notes); ?></dd></div><?php endif; ?>
                </dl>
            <?php else: ?>
                <div class="alert alert-error">No matching request was found. Verify the tracking code and contact number.</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/public/requests/track.blade.php ENDPATH**/ ?>