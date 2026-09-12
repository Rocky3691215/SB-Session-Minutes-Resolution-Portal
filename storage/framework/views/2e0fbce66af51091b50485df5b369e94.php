<?php $__env->startSection('title', 'Request Certified Copy'); ?>

<?php $__env->startSection('content'); ?>
<section class="card narrow-card">
    <div class="eyebrow">PUBLIC SERVICE</div>
    <h1>Request a Certified Copy</h1>
    <p class="muted">Submit your request to the SB Secretary. Keep the tracking code shown after submission.</p>

    <form method="POST" action="<?php echo e(route('public.requests.store')); ?>" class="stack-form">
        <?php echo csrf_field(); ?>
        <label for="requester_name">Full Name</label>
        <input id="requester_name" name="requester_name" value="<?php echo e(old('requester_name')); ?>" required maxlength="255">

        <label for="contact_number">Contact Number</label>
        <input id="contact_number" name="contact_number" value="<?php echo e(old('contact_number')); ?>" required maxlength="50">

        <label for="document_id">Document</label>
        <select id="document_id" name="document_id" required>
            <option value="">Select a published document</option>
            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($item->id); ?>" <?php if(old('document_id', $document?->id) == $item->id): echo 'selected'; endif; ?>>
                    <?php echo e($item->document_number); ?> — <?php echo e($item->title); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <div class="two-col">
            <div>
                <label for="copies">Number of Copies</label>
                <input id="copies" name="copies" type="number" min="1" max="20" value="<?php echo e(old('copies', 1)); ?>" required>
            </div>
            <div>
                <label for="pickup_date">Preferred Pickup Date</label>
                <input id="pickup_date" name="pickup_date" type="date" min="<?php echo e(now()->toDateString()); ?>" value="<?php echo e(old('pickup_date')); ?>" required>
            </div>
        </div>

        <label for="notes">Notes <span class="muted">(optional)</span></label>
        <textarea id="notes" name="notes" rows="4" maxlength="2000" placeholder="Additional instructions..."><?php echo e(old('notes')); ?></textarea>

        <button class="btn btn-primary" type="submit">Submit Request</button>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Capstone\resources\views/public/requests/create.blade.php ENDPATH**/ ?>