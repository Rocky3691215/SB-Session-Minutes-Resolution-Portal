<?php $__env->startSection('title', 'Publish Document'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div><h1>Publish Document</h1></div>
    <a class="btn btn-light" href="<?php echo e(route('admin.documents.index')); ?>">Back</a>
</div>

<section class="card narrow-card">
    <form method="POST" action="<?php echo e(route('admin.documents.store')); ?>" enctype="multipart/form-data" class="stack-form">
        <?php echo csrf_field(); ?>
        <label for="session_name">Session Name / Title</label>
        <input id="session_name" name="session_name" value="<?php echo e(old('session_name')); ?>" required maxlength="255" placeholder="e.g. Annual Budget">

        <div class="two-col">
            <div>
                <label for="type">Document Type</label>
                <select id="type" name="type" required>
                    <option value="">Select type</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->name); ?>" <?php if(old('type') == $type->name): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="session_id">Session ID</label>
                <input id="session_id" name="session_id" value="<?php echo e(old('session_id')); ?>" placeholder="2026-001" maxlength="100">
            </div>
        </div>

        <div class="two-col">
            <div>
                <label for="session_date">Session Date</label>
                <input id="session_date" name="session_date" type="date" value="<?php echo e(old('session_date', now()->toDateString())); ?>" required>
            </div>
            <div>
                <label for="sponsors">Sponsor/s</label>
                <input id="sponsors" name="sponsors" value="<?php echo e(old('sponsors', 'Councilor')); ?>" maxlength="255">
            </div>
        </div>

        <label for="tags">Tags</label>
        <input id="tags" name="tags" value="<?php echo e(old('tags')); ?>" placeholder="title, barangay,etc.">

        <label class="checkbox-row"><input type="checkbox" name="is_public" value="1" <?php if(old('is_public', true)): echo 'checked'; endif; ?>><span>Publish this document to the public archive</span></label>

        <label for="pdf">PDF File <span class="muted">(maximum 10 MB)</span></label>
        <input id="pdf" name="pdf" type="file" accept="application/pdf,.pdf" required>

        <button class="btn btn-primary" type="submit">Upload & Publish</button>
    </form>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/admin/documents/create.blade.php ENDPATH**/ ?>