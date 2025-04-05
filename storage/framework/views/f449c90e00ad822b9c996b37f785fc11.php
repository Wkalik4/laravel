<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/carts.css')); ?>">
    <link href="<?php echo e(asset('css/registers.css')); ?>" rel="stylesheet">


    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
</head>

<body class="font-sans antialiased">
    
   

        <!-- Page Content -->
        <main class="container mx-auto mt-8"> <!-- Добавляем container для контента -->
            <div class="card"> <!-- Оборачиваем контент в card -->
                <div class="card-body">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </main>
    </div>
</body>

</html><?php /**PATH C:\OSPanel\home\katalog.local\resources\views/layouts/app.blade.php ENDPATH**/ ?>