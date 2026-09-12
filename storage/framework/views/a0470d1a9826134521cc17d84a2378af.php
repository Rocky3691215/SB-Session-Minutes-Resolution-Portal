<?php $__env->startSection('title', 'Manage Documents'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div>
        <div class="eyebrow">DOCUMENT MANAGEMENT</div>
        <h1>Documents</h1>
        <p class="muted">Search, review, edit, publish, or archive official records.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a class="btn btn-light" href="<?php echo e(route('admin.dashboard')); ?>">Back</a>
        <a class="btn btn-primary" href="<?php echo e(route('admin.documents.create')); ?>">+ Publish Document</a>
    </div>
</div>

<section class="card">
    <form method="GET" class="filter-grid">
        <div class="field wide"><label for="q">Search</label><input id="q" name="q" value="<?php echo e(request('q')); ?>" placeholder="ID, session name, sponsors, session ID, tags..."></div>
        <div class="field"><label for="type">Type</label><select id="type" name="type"><option value="">All</option><?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($type->name); ?>" <?php if(request('type') === $type->name): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="field"><label for="status">Status</label><select id="status" name="status"><option value="">All</option><option value="published" <?php if(request('status') === 'published'): echo 'selected'; endif; ?>>Published</option><option value="archived" <?php if(request('status') === 'archived'): echo 'selected'; endif; ?>>Archived</option></select></div>
        <div class="field actions-end"><button class="btn btn-primary" type="submit">Search</button><a class="btn btn-light" href="<?php echo e(route('admin.documents.index')); ?>">Reset</a></div>
    </form>
</section>

<section class="card">
    <?php if($documents->isEmpty()): ?>
        <div class="empty-state">No documents found.</div>
    <?php else: ?>
        <div class="table-wrap"><table><thead><tr><th>ID</th><th>Session Name</th><th>Type</th><th>Date</th><th>Visibility</th><th>Status</th><th>Actions</th></tr></thead><tbody>
        <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong><?php echo e($document->document_id); ?></strong></td>
                <td><?php echo e($document->session_name); ?><div class="small muted"><?php echo e($document->filename); ?></div></td>
                <td><?php echo e($document->type ?? '—'); ?></td>
                <td><?php echo e($document->session_date ? \Carbon\Carbon::parse($document->session_date)->format('M d, Y') : '—'); ?></td>
                <td><?php echo e($document->is_public ? 'Public' : 'Private'); ?></td>
                <td><span class="badge <?php echo e($document->status === 'published' ? 'badge-completed' : 'badge-cancelled'); ?>"><?php echo e(ucfirst($document->status)); ?></span></td>
                <td class="actions-cell">
                    <a class="btn btn-sm btn-view" href="<?php echo e(route('admin.documents.file', $document)); ?>" target="_blank" rel="noopener">View</a>
                    <a class="btn btn-sm btn-light" href="<?php echo e(route('admin.documents.edit', $document)); ?>">Edit</a>
                    <?php if(! $document->trashed()): ?>
                        <form method="POST" action="<?php echo e(route('admin.documents.destroy', $document)); ?>" class="inline-form" onsubmit="return confirm('Archive this document from the active list?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger" type="submit">Archive</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody></table></div>
        <div class="pagination-wrap"><?php echo e($documents->links()); ?></div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/admin/documents/index.blade.php ENDPATH**/ ?>