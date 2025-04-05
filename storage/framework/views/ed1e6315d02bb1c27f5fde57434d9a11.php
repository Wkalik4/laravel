

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Редактировать профиль</h1>

    <form method="POST" action="<?php echo e(route('profile.update')); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label for="last_name" class="form-label">Фамилия</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e(old('last_name', $user->profile ? $user->profile->last_name : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="first_name" class="form-label">Имя</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo e(old('first_name', $user->profile ? $user->profile->first_name : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="middle_name" class="form-label">Отчество</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo e(old('middle_name', $user->profile ? $user->profile->middle_name : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Страна</label>
            <input type="text" class="form-control" id="country" name="country" value="<?php echo e(old('country', $user->profile ? $user->profile->country : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Город</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo e(old('city', $user->profile ? $user->profile->city : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="street" class="form-label">Улица</label>
            <input type="text" class="form-control" id="street" name="street" value="<?php echo e(old('street', $user->profile ? $user->profile->street : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="house_number" class="form-label">Номер дома</label>
            <input type="text" class="form-control" id="house_number" name="house_number" value="<?php echo e(old('house_number', $user->profile ? $user->profile->house_number : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="apartment_number" class="form-label">Номер квартиры</label>
            <input type="text" class="form-control" id="apartment_number" name="apartment_number" value="<?php echo e(old('apartment_number', $user->profile ? $user->profile->apartment_number : '')); ?>">
        </div>

        <div class="mb-3">
            <label for="postal_code" class="form-label">Почтовый индекс</label>
            <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo e(old('postal_code', $user->profile ? $user->profile->postal_code : '')); ?>">
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\OSPanel\home\katalog.local\resources\views/profile/edit.blade.php ENDPATH**/ ?>