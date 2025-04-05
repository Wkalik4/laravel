

<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <h1>Корзина</h1>

        <?php if(count($cartItemsWithProducts) > 0): ?>
            <div class="cart-container">
                <?php $__currentLoopData = $cartItemsWithProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="cart-item">
                        <div class="cart-item-image">
                            <?php if($item['product']->img): ?>
                                <img src="" alt="<?php echo e($item['product']->наименование_полное); ?>">
                            <?php else: ?>
                                <img src="" alt="Нет изображения">
                            <?php endif; ?>
                        </div>
                        <div class="cart-item-details">
                            <h5 class="cart-item-title"><?php echo e($item['product']->наименование_полное); ?></h5>
                            <p class="cart-item-description"><?php echo e($item['product']->description); ?></p>
                        </div>
                        <div class="cart-item-quantity">
                            <button class="btn btn-sm btn-outline-secondary decrement-quantity" data-product-id="<?php echo e($item['product']->id); ?>" data-action="decrement">-</button>
                            <span class="cart-item-quantity-value" id="quantity-<?php echo e($item['product']->id); ?>"><?php echo e($item['cartItem']->quantity); ?></span>
                            <button class="btn btn-sm btn-outline-secondary increment-quantity" data-product-id="<?php echo e($item['product']->id); ?>" data-action="increment">+</button>
                        </div>
                        <div class="cart-item-price">
                            <?php echo e(number_format($item['product']->цена, 2, ',', ' ')); ?> руб.
                        </div>
                        <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($item['product']->id); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p>Ваша корзина пуста.</p>
        <?php endif; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateQuantity = (productId, action, element) => {
                fetch('/cart/update-quantity', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        action: action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`quantity-${productId}`).textContent = data.quantity;
                    } else {
                        alert('Ошибка: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка при обновлении количества.');
                });
            };

            document.querySelectorAll('.increment-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    updateQuantity(productId, 'increment', this);
                });
            });

            document.querySelectorAll('.decrement-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    updateQuantity(productId, 'decrement', this);
                });
            });
        });
        
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\katalog.local\resources\views/cart/index.blade.php ENDPATH**/ ?>