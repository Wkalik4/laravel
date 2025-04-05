

<?php $__env->startSection('title', 'Крепежи'); ?>

<?php $__env->startSection('content'); ?>
    <h1>Крепежи</h1>
    <div class="product-grid" >
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-item">

                <?php if($product->img): ?>
                    <img src="<?php echo e($product->img); ?>" alt="" class="product-image">
                <?php else: ?>
                    <img src="" alt="No Image" class="product-image">
                <?php endif; ?>
                <h2 class="product-title"><?php echo e($product->наименование_полное); ?></h2>
                <p class="product-description"><?php echo e($product->description); ?></p>
                <p class="product-price">Цена: <?php echo e($product->цена); ?> руб.</p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.maket', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\katalog.local\resources\views/categories/fasteners.blade.php ENDPATH**/ ?>