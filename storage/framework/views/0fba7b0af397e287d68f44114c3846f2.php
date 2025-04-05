
<?php $__env->startSection('title', 'autoVaz'); ?>
<?php $__env->startSection('content'); ?>
    <h1>АвтоВАЗ</h1>
    <div class="product-grid" >
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="product-item">

                <?php if($product->img): ?>
                    <img src="<?php echo e($product->img); ?>" alt="<?php echo e($product->наименование_полное); ?>" class="product-image">
                <?php else: ?>
                    <img src="" alt="No Image" class="product-image">
                <?php endif; ?>
                <h2 class="product-title"><?php echo e($product->наименование_полное); ?></h2>
                <p class="product-description"><?php echo e($product->description); ?></p>
                <p class="product-price">Цена: <?php echo e($product->цена); ?> руб.</p>

                <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                    <?php
                        // Проверяем, есть ли товар в корзине у пользователя
                        $query = DB::table('carts')->where('product_id', $product->id);
                        if (Auth::check()) {
                            $query->where('user_email', Auth::user()->email);
                        } else {
                            $query->where('session_id', session()->getId());
                        }
                        $isInCart = $query->exists();
                    ?>

                    <button type="submit" class="product-grid-cart-botton-to-db <?php echo e($isInCart ? 'product-grid-cart-button-in-cart' : ''); ?>">
                        <?php echo e($isInCart ? 'В корзине' : 'В корзину'); ?>

                    </button>
                </form>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.maket', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\katalog.local\resources\views/categories/autoVaz.blade.php ENDPATH**/ ?>