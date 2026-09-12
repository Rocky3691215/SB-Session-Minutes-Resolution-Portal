<?php $__env->startSection('title', 'Public Archive'); ?>

<?php $__env->startSection('content'); ?>
<section class="hero card">
    <div>
        <div class="eyebrow">PUBLIC RECORDS</div>
        <h1>Search Official SB Documents</h1>
        <p class="muted">Find published resolutions, minutes, ordinances, and other public records.</p>
    </div>
</section>

<section class="card">
    <form method="GET" action="<?php echo e(route('home')); ?>" class="filter-grid">
        <!-- General Keyword/Tag Search -->
        <div class="field wide">
            <label for="q">Keyword</label>
            <input id="q" name="q" value="<?php echo e(request('q')); ?>" placeholder="Search topics, tags, or document text...">
        </div>
        
        <!-- Filter 1: Type -->
        <div class="field">
            <label for="type">Document Type</label>
            <select id="type" name="type">
                <option value="">All types</option>
                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type->name); ?>" <?php if(request('type') === $type->name): echo 'selected'; endif; ?>><?php echo e($type->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="field actions-end">
            <button class="btn btn-primary" type="submit">Search</button>
            <a class="btn btn-light" href="<?php echo e(route('home')); ?>">Reset</a>
        </div>
    </form>
</section>

<section class="card">
    <div class="section-heading">
        <div>
            <h2>Available Documents</h2>
            <p class="muted"><?php echo e($documents->total()); ?> published record(s)</p>
        </div>
    </div>

    <?php if($documents->isEmpty()): ?>
        <div class="empty-state">No public documents matched your search.</div>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Session Name</th>
                        <th>Type</th>
                        <th>Session Date</th>
                        <th>Sponsors</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><strong><?php echo e($document->session_name); ?></strong></td>
                            <td><?php echo e($document->type ?? 'Uncategorized'); ?></td>
                            <td><?php echo e($document->session_date ? \Carbon\Carbon::parse($document->session_date)->format('M d, Y') : '—'); ?></td>
                            <td><?php echo e($document->sponsors ?? '—'); ?></td>
                            <td class="actions-cell">
                                <a class="btn btn-sm btn-view" href="<?php echo e(route('public.documents.file', $document)); ?>" target="_blank" rel="noopener">Read PDF</a>
                                <a class="btn btn-sm btn-light" href="<?php echo e(route('public.requests.create', ['document' => $document->document_id])); ?>">Request Copy</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="pagination-wrap"><?php echo e($documents->links()); ?></div>
    <?php endif; ?>
</section>
<script src="<?php echo e(asset('js/public.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Capstone\resources\views/public/index.blade.php ENDPATH**/ ?>