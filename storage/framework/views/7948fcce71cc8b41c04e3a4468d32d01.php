<!DOCTYPE html>
<html>
<head>
    <title>Случайные товары</title>
    <link href="<?php echo e(asset('css/footer.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/index.css')); ?>" rel="stylesheet">


</head>
    
        <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
    </div>
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>
<?php /**PATH C:\OSPanel\home\katalog.local\resources\views/index.blade.php ENDPATH**/ ?>