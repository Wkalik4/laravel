<nav class="navbar navbar-expand-lg navbar-light">
    <div class="wraper_header">
        <div class="ful-logo">
            <a href="/"><img class="logo-img" src="img/sys/Treygolnik_logo.png" alt="Логотип"></a>
        </div>
        <div class="wraper_header_list">
            <div class="navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('oils')); ?>">Масла</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('tools')); ?>">Инструменты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('fasteners')); ?>">Крепежи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('autoСhemistry')); ?>">Автохимия</a>
                    </li>
                </ul>
            </div>
            <div class="navbar-collapse" id="navbarNav2">  <!-- Убрал дублирование id -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('gazel')); ?>">Газель</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('mtz')); ?>">МТЗ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('autoVaz')); ?>">АвтоВАЗ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('ural')); ?>">Урал</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('kamaz')); ?>">Камаз</a>
                    </li>
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                         
                        </li>
                        <?php if(Auth::user()->role->name == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('users.index')); ?>">Управление пользователями</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        
        <div class="wraper_reg">
            <?php if(auth()->guard()->check()): ?>
                <a href="/profile/edit" class="button_header_dop_nav"><?php echo e(Auth::user()->name); ?></a>
                <!-- Ссылка для перехода в корзину -->
                <a href="<?php echo e(route('cart.index')); ?>" class="button_header_dop_nav">Корзина</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="button_header_dop_nav">Выход</button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('register')); ?>" class="button_header_dop_nav">Регистрация</a> |
                
                <a href="<?php echo e(route('login')); ?>" onclick="document.cookie = 'guestSessionId=<?php echo e(session()->getId()); ?>'; return true;" class="button_header_dop_nav">Войти</a>
            <?php endif; ?>
        </div>
   


    </div>
</nav><?php /**PATH C:\OSPanel\home\katalog.local\resources\views/layouts/header.blade.php ENDPATH**/ ?>