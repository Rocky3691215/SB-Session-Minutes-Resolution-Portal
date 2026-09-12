<?php $__env->startSection('title', 'Publish Document'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div><div class="eyebrow">DOCUMENT MANAGEMENT</div><h1>Publish Document</h1><p class="muted">Upload a PDF and store its searchable metadata in SQL.</p></div>
    <a class="btn btn-light" href="<?php echo e(route('admin.documents.index')); ?>">Back</a>
</div>

<section class="card narrow-card">
    <form method="POST" action="<?php echo e(route('admin.documents.store')); ?>" enctype="multipart/form-data" class="stack-form">
        <?php echo csrf_field(); ?>
        <label for="title">Title</label>
        <input id="title" name="title" value="<?php echo e(old('title')); ?>" required maxlength="255" placeholder="e.g. Resolution approving the annual budget">

        <div class="two-col">
            <div>
                <label for="document_type_id">Document Type</label>
                <select id="document_type_id" name="document_type_id" required>
                    <option value="">Select type</option>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>" <?php if(old('document_type_id') == $type->id): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="session_number">Session Number</label>
                <input id="session_number" name="session_number" value="<?php echo e(old('session_number')); ?>" placeholder="2026-001" maxlength="100">
            </div>
        </div>

        <div class="two-col">
            <div>
                <label for="document_date">Document Date</label>
                <input id="document_date" name="document_date" type="date" value="<?php echo e(old('document_date', now()->toDateString())); ?>" required>
            </div>
            <div>
                <label for="author">Author / Office</label>
                <input id="author" name="author" value="<?php echo e(old('author', 'SB Secretary')); ?>" maxlength="255">
            </div>
        </div>

        <label for="tags">Tags</label>
        <input id="tags" name="tags" value="<?php echo e(old('tags')); ?>" placeholder="budget, barangay, finance">

        <label class="checkbox-row"><input type="checkbox" name="is_public" value="1" <?php if(old('is_public', true)): echo 'checked'; endif; ?>><span>Publish this document to the public archive</span></label>

        <label for="pdf">PDF File <span class="muted">(maximum 10 MB)</span></label>
        <input id="pdf" name="pdf" type="file" accept="application/pdf,.pdf" required>

        <button class="btn btn-primary" type="submit">Upload & Publish</button>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Capstone\resources\views/admin/documents/create.blade.php ENDPATH**/ ?>