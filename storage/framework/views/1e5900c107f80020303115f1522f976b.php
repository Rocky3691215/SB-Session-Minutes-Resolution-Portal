<?php $__env->startSection('title', 'Request a Certified Copy'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div>
        <div class="eyebrow">PUBLIC SERVICE</div>
        <h1>Request a Certified Copy</h1>
        <p class="muted">Submit your request to the SB Secretary. Keep the tracking code shown after submission.</p>
    </div>
    <a class="btn btn-light" href="<?php echo e(route('home')); ?>">Back</a>
</div>

<section class="card">
    <form method="POST" action="<?php echo e(route('public.requests.store')); ?>" enctype="multipart/form-data" class="stack-form">
        <?php echo csrf_field(); ?>

        <label for="requester_name">Full Name</label>
        <input id="requester_name" name="requester_name" value="<?php echo e(old('requester_name')); ?>" required maxlength="255" placeholder="e.g. Juan Dela Cruz">

        <label for="contact_number">Contact Number <span class="muted">(e.g., 09123456789)</span></label>
        <input id="contact_number" name="contact_number" value="<?php echo e(old('contact_number')); ?>" required pattern="^(09|\+639)\d{9}$" maxlength="13" placeholder="09123456789">

        <label for="document_id">Document</label>
        <select id="document_id" name="document_id" required>
            <option value="">— Select a document —</option>
            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($doc->document_id); ?>" <?php if((isset($document) && $document->document_id === $doc->document_id) || old('document_id') === $doc->document_id): echo 'selected'; endif; ?>>
                    <?php echo e($doc->session_name); ?> (<?php echo e($doc->type); ?>)
                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <div class="two-col">
            <div>
                <label for="copies">Number of Copies</label>
                <input id="copies" name="copies" type="number" min="1" value="<?php echo e(old('copies', 1)); ?>" required>
            </div>
            <div>
                <label for="pickup_date">Preferred Pickup Date</label>
                <input id="pickup_date" name="pickup_date" type="date" value="<?php echo e(old('pickup_date')); ?>" required>
            </div>
        </div>

        <label for="reason">Reason / Purpose</label>
        <input id="reason" name="reason" value="<?php echo e(old('reason')); ?>" required maxlength="255" placeholder="e.g. Legal reference, educational purposes">

        <label for="valid_id">Valid ID <span class="muted">(JPEG, PNG, JPG - max 5MB)</span></label>
        <input id="valid_id" name="valid_id" type="file" accept="image/jpeg,image/png,image/jpg" required>

        <button class="btn btn-primary" type="submit">Submit Request</button>
    </form>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/public/requests/create.blade.php ENDPATH**/ ?>