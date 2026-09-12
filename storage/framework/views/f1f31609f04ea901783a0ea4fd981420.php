

<?php $__env->startSection('title', 'My Requests'); ?>

<?php $__env->startSection('content'); ?>
<div class="admin-toolbar">
    <div>
        <div class="eyebrow">PUBLIC RECORDS</div>
        <h1>Submitted Requests</h1>
        <p class="muted">View the status and fees of your certified copy requests.</p>
    </div>
    <a class="btn btn-light" href="<?php echo e(route('home')); ?>">Back to Archive</a>
</div>

<section class="card">
    <?php if($requests->isEmpty()): ?>
        <div class="empty-state">No requests have been submitted yet.</div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Requester</th>
                        <th>Document</th>
                        <th>Copies</th>
                        <th>Fee</th>
                        <th>Pickup Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><strong><?php echo e($req->request_id); ?></strong></td>
                            <td><?php echo e($req->requester_name); ?></td>
                            <td><?php echo e($req->document->session_name ?? $req->document_id); ?></td>
                            <td><?php echo e($req->copies); ?></td>
                            <td>₱<?php echo e(number_format($req->fee ?? 0, 2)); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($req->pickup_date)->format('M d, Y')); ?></td>
                            <td>
                                <span class="badge <?php echo e($req->status === 'Completed' ? 'badge-completed' : ($req->status === 'Cancelled' ? 'badge-cancelled' : ($req->status === 'Ready for Pickup' ? 'badge-ready' : 'badge-pending'))); ?>"><?php echo e($req->status); ?></span>
                            </td>
                            <td class="actions-cell">
                                <div style="display: flex; gap: 0.5rem; align-items: center;">
                                    <?php if($req->status === 'Pending'): ?>
                                        <form method="POST" action="<?php echo e(route('public.requests.cancel', $req)); ?>" onsubmit="return confirm('Are you sure you want to cancel this request?');">
                                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                            <button class="btn btn-sm btn-light" type="submit">Cancel</button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" action="<?php echo e(route('public.requests.destroy', $req)); ?>" onsubmit="return confirm('Are you sure you want to delete this request record?');">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger" type="submit" style="background-color: #dc3545; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 4px;">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap"><?php echo e($requests->links()); ?></div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/public/requests/index.blade.php ENDPATH**/ ?>