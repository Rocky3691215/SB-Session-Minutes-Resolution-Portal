<?php $__env->startSection('title', 'Edit Document'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div><div class="eyebrow">DOCUMENT MANAGEMENT</div><h1>Edit <?php echo e($document->document_id); ?></h1><p class="muted">Update metadata, visibility, status, or replace the PDF.</p></div>
    <a class="btn btn-light" href="<?php echo e(route('admin.documents.index')); ?>">Back</a>
</div>

<section class="card narrow-card">
    <form method="POST" action="<?php echo e(route('admin.documents.update', $document->id)); ?>" enctype="multipart/form-data" class="stack-form">
        <?php echo csrf_field(); ?>

        <label for="title">Title / Session Name</label>
        <input id="title" name="title" value="<?php echo e(old('title', $document->session_name)); ?>" required maxlength="255">

        <div class="two-col">
            <div>
                <label for="document_type_id">Document Type</label>
                <select id="document_type_id" name="document_type_id" required>
                    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->name); ?>" <?php if(old('document_type_id', $document->type) === $type->name): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="session_number">Session Number / ID</label>
                <input id="session_number" name="session_number" value="<?php echo e(old('session_number', $document->session_id)); ?>">
            </div>
        </div>

        <div class="two-col">
            <div>
                <label for="document_date">Document Date</label>
                <input id="document_date" name="document_date" type="date" value="<?php echo e(old('document_date', $document->session_date?->format('Y-m-d'))); ?>" required>
            </div>
            <div>
                <label for="author">Author / Sponsors</label>
                <input id="author" name="author" value="<?php echo e(old('author', $document->sponsors)); ?>">
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
            <div>
                <label for="is_public" style="display: block; margin-bottom: 0.5rem;">Visibility</label>
                <label style="font-weight: normal; display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem; outline: none; box-shadow: none;">
                    <input type="checkbox" name="is_public" value="1" <?php if(old('is_public', $document->is_public)): echo 'checked'; endif; ?> style="outline: none; box-shadow: none;"> Make Publicly Accessible
                </label>
            </div>
        </div>

        <label for="pdf">Replace PDF <span class="muted">(optional, maximum 10 MB)</span></label>
        <input id="pdf" name="pdf" type="file" accept="application/pdf,.pdf">
        <div class="small muted">Current file: <?php echo e($document->filename ?? 'None'); ?></div>

        <button class="btn btn-primary" type="submit" style="margin-top: 1.5rem;">Save Changes</button>
    </form>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/admin/documents/edit.blade.php ENDPATH**/ ?>