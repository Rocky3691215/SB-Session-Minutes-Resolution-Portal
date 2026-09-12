<?php $__env->startSection('title', 'Manage Requests'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div><div class="eyebrow">REQUEST MANAGEMENT</div><h1>Certified Copy Requests</h1><p class="muted">Review incoming requests and update their processing status.</p></div>
    <a class="btn btn-light" href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
</div>

<section class="card">
    <form method="GET" class="filter-grid">
        <div class="field wide"><label for="q">Search</label><input id="q" name="q" value="<?php echo e(request('q')); ?>" placeholder="Tracking code, requester, contact, document..."></div>
        <div class="field"><label for="status">Status</label><select id="status" name="status"><option value="">All statuses</option><?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if(request('status') === $status): echo 'selected'; endif; ?>><?php echo e($status); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="field actions-end"><button class="btn btn-primary" type="submit">Search</button><a class="btn btn-light" href="<?php echo e(route('admin.requests.index')); ?>">Reset</a></div>
    </form>
</section>

<section class="card">
    <?php if($requests->isEmpty()): ?>
        <div class="empty-state">No requests found.</div>
    <?php else: ?>
        <div class="table-wrap"><table><thead><tr><th>Tracking</th><th>Requester</th><th>Contact</th><th>Document</th><th>Copies</th><th>Pickup</th><th>Status</th><th>Update</th></tr></thead><tbody>
        <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><strong><?php echo e($item->tracking_code); ?></strong></td>
                <td><?php echo e($item->requester_name); ?></td>
                <td><?php echo e($item->contact_number); ?></td>
                <td><?php echo e($item->document->document_number); ?><div class="small muted"><?php echo e($item->document->title); ?></div></td>
                <td><?php echo e($item->copies); ?></td>
                <td><?php echo e($item->pickup_date->format('M d, Y')); ?></td>
                <td><span class="badge <?php echo e($item->status === 'Completed' ? 'badge-completed' : ($item->status === 'Cancelled' ? 'badge-cancelled' : ($item->status === 'Ready for Pickup' ? 'badge-ready' : 'badge-pending'))); ?>"><?php echo e($item->status); ?></span></td>
                <td>
                    <form method="POST" action="<?php echo e(route('admin.requests.update', $item)); ?>" class="compact-form">
                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                        <select name="status" aria-label="Status for <?php echo e($item->tracking_code); ?>">
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($status); ?>" <?php if($item->status === $status): echo 'selected'; endif; ?>><?php echo e($status); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <input name="notes" value="<?php echo e($item->notes); ?>" placeholder="Optional note">
                        <button class="btn btn-sm btn-primary" type="submit">Save</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody></table></div>
        <div class="pagination-wrap"><?php echo e($requests->links()); ?></div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Capstone\resources\views/admin/requests/index.blade.php ENDPATH**/ ?>