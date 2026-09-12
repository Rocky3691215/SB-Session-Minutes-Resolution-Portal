<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div>
        <h1>Administrator Dashboard</h1>
        <p class="muted">Welcome!</p>
    </div>
    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button class="btn btn-light" type="submit">Log out</button>
    </form>
</div>

<section class="stats-grid">
    <div class="stat-card"><span><?php echo e($stats['total_documents']); ?></span><small>Total Documents</small></div>
    <div class="stat-card"><span><?php echo e($stats['public_documents']); ?></span><small>Published Public</small></div>
    <div class="stat-card"><span><?php echo e($stats['pending_requests']); ?></span><small>Pending Requests</small></div>
    <div class="stat-card"><span><?php echo e($stats['ready_requests']); ?></span><small>Ready for Pickup</small></div>
    <div class="stat-card"><span><?php echo e($stats['completed_requests']); ?></span><small>Completed</small></div>
</section>

<div class="admin-nav card">
    <a class="btn btn-primary" href="<?php echo e(route('admin.documents.create')); ?>">+ Publish Document</a>
    <a class="btn btn-light" href="<?php echo e(route('admin.documents.index')); ?>">Manage Documents</a>
    <a class="btn btn-light" href="<?php echo e(route('admin.requests.index')); ?>">Manage Requests</a>
</div>

<div class="dashboard-grid">
    <section class="card">
        <div class="section-heading"><h2>Recent Documents</h2><a href="<?php echo e(route('admin.documents.index')); ?>">View all</a></div>
        <?php if($recentDocuments->isEmpty()): ?>
            <div class="empty-state">No documents yet.</div>
        <?php else: ?>
            <div class="table-wrap"><table><thead><tr><th>ID</th><th>Title</th><th>Type</th><th>Status</th></tr></thead><tbody>
                <?php $__currentLoopData = $recentDocuments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($document->document_id); ?></td>
                        <td><?php echo e($document->session_name); ?></td>
                        <td><?php echo e($document->type ?? '—'); ?></td>
                        <td><span class="badge <?php echo e($document->status === 'published' ? 'badge-completed' : 'badge-cancelled'); ?>"><?php echo e(ucfirst($document->status)); ?></span></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody></table></div>
        <?php endif; ?>
    </section>

    <section class="card">
        <div class="section-heading"><h2>Recent Requests</h2><a href="<?php echo e(route('admin.requests.index')); ?>">View all</a></div>
        <?php if($recentRequests->isEmpty()): ?>
            <div class="empty-state">No requests yet.</div>
        <?php else: ?>
            <div class="table-wrap"><table><thead><tr><th>Tracking ID</th><th>Requester</th><th>Status</th></tr></thead><tbody>
                <?php $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><td><?php echo e($request->request_id); ?></td><td><?php echo e($request->requester_name); ?></td><td><span class="badge <?php echo e(strtolower($request->status) === 'completed' ? 'badge-completed' : (strtolower($request->status) === 'cancelled' ? 'badge-cancelled' : (strtolower($request->status) === 'ready for pickup' ? 'badge-ready' : 'badge-pending'))); ?>"><?php echo e($request->status); ?></span></td></tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody></table></div>
        <?php endif; ?>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>