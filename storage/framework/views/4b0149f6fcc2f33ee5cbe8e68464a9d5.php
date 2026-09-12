<?php $__env->startSection('title', 'Edit Document'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div><div class="eyebrow">DOCUMENT MANAGEMENT</div><h1>Edit <?php echo e($document->document_number); ?></h1><p class="muted">Update metadata, visibility, status, or replace the PDF.</p></div>
    <a class="btn btn-light" href="<?php echo e(route('admin.documents.index')); ?>">Back</a>
</div>

<section class="card narrow-card">
    <form method="POST" action="<?php echo e(route('admin.documents.update', $document)); ?>" enctype="multipart/form-data" class="stack-form">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <label>Document Number</label>
        <input value="<?php echo e($document->document_number); ?>" disabled>

        <label for="title">Title</label>
        <input id="title" name="title" value="<?php echo e(old('title', $document->title)); ?>" required maxlength="255">

        <div class="two-col">
            <div>
                <label for="document_type_id">Document Type</label>
                <select id="document_type_id" name="document_type_id" required>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>" <?php if(old('document_type_id', $document->document_type_id) == $type->id): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="session_number">Session Number</label>
                <input id="session_number" name="session_number" value="<?php echo e(old('session_number', $document->session_number)); ?>">
            </div>
        </div>

        <div class="two-col">
            <div>
                <label for="document_date">Document Date</label>
                <input id="document_date" name="document_date" type="date" value="<?php echo e(old('document_date', $document->document_date?->toDateString())); ?>" required>
            </div>
            <div>
                <label for="author">Author / Office</label>
                <input id="author" name="author" value="<?php echo e(old('author', $document->author)); ?>">
            </div>
        </div>

        <label for="tags">Tags</label>
        <input id="tags" name="tags" value="<?php echo e(old('tags', $document->tags)); ?>">

        <div class="two-col">
            <div>
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="published" <?php if(old('status', $document->status) === 'published'): echo 'selected'; endif; ?>>Published</option>
                    <option value="archived" <?php if(old('status', $document->status) === 'archived'): echo 'selected'; endif; ?>>Archived</option>
                </select>
            </div>
            <div class="align-end">
                <label class="checkbox-row"><input type="checkbox" name="is_public" value="1" <?php if(old('is_public', $document->is_public)): echo 'checked'; endif; ?>><span>Visible in public archive</span></label>
            </div>
        </div>

        <label for="pdf">Replace PDF <span class="muted">(optional, maximum 10 MB)</span></label>
        <input id="pdf" name="pdf" type="file" accept="application/pdf,.pdf">
        <div class="small muted">Current file: <?php echo e($document->file_name); ?> (<?php echo e($document->file_size_human); ?>)</div>

        <button class="btn btn-primary" type="submit">Save Changes</button>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Capstone\resources\views/admin/documents/edit.blade.php ENDPATH**/ ?>