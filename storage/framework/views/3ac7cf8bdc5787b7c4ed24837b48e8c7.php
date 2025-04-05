<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Таблица товаров</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Таблица товаров</h1>

    <?php if(session('successMessage')): ?>
        <div class="alert alert-success">
            <?php echo e(session('successMessage')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('infoMessage')): ?>
        <div class="alert alert-info">
            <?php echo e(session('infoMessage')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('errorMessage')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('errorMessage')); ?>

        </div>
    <?php endif; ?>

    <!-- Кнопка "Импортировать номенклатуру" вне модального окна -->
    <?php if(auth()->guard()->check()): ?>
        <button id="importNomenclatureBtnOutside"
            style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer;">Импортировать
            номенклатуру</button>
    <?php endif; ?>


    <?php if(auth()->guard()->check()): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Действия</th>
                    <th>Добавление картинки</th>
                </tr>
            </thead>
            <tbody>
    <?php $__currentLoopData = $товары; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $товар): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($товар->id); ?></td>
            <td><?php echo e($товар->наименование_полное); ?></td>
            <td><?php echo e($товар->description); ?></td>
            <td><?php echo e($товар->цена); ?></td>
                
            
            <td>
    <div>
        <!-- выподающий список -->
        <select name="category_id" data-товар-id="<?php echo e($товар->id); ?>" class="categorySelect">
            <option value="" selected>Выберите категорию</option>
            <option value="масла" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'масла'): ?> selected <?php endif; ?>>Масла</option>
            <option value="tools" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'tools'): ?> selected <?php endif; ?>>Инструменты</option>
            <option value="fasteners" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'fasteners'): ?> selected <?php endif; ?>>Крепежи</option>
            <option value="mtz" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'mtz'): ?> selected <?php endif; ?>>МТЗ</option>
            <option value="gazel" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'gazel'): ?> selected <?php endif; ?>>Газель</option>
            <option value="autoСhemistry" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'autoСhemistry'): ?> selected <?php endif; ?>>Автохимия</option>
            <option value="autoVaz" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'autoVaz'): ?> selected <?php endif; ?>>АвтоВАЗ</option>
            <option value="ural" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'ural'): ?> selected <?php endif; ?>>Урал</option>
            <option value="kamaz" <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['selectedCategory'] == 'kamaz'): ?> selected <?php endif; ?>>Камаз</option>
        </select>
        
        <!-- уже выбранные категории -->
        <div class="selected-categories">
            <?php if(isset($товары_в_категориях[$товар->id])): ?>
                <?php if(isset($товары_в_категориях[$товар->id]['масла']) && $товары_в_категориях[$товар->id]['масла']): ?>
                    <span data-category="масла">Масла</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['tools']) && $товары_в_категориях[$товар->id]['tools']): ?>
                    <span data-category="tools">Инструменты</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['fasteners']) && $товары_в_категориях[$товар->id]['fasteners']): ?>
                    <span data-category="fasteners">Крепежи</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['mtz']) && $товары_в_категориях[$товар->id]['mtz']): ?>
                    <span data-category="mtz">МТЗ</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['gazel']) && $товары_в_категориях[$товар->id]['gazel']): ?>
                    <span data-category="gazel">Газель</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['autoСhemistry']) && $товары_в_категориях[$товар->id]['autoСhemistry']): ?>
                    <span data-category="autoСhemistry">Автохимия</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['autoVaz']) && $товары_в_категориях[$товар->id]['autoVaz']): ?>
                    <span data-category="autoСhemistry">АвтоВАЗ</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['ural']) && $товары_в_категориях[$товар->id]['ural']): ?>
                    <span data-category="autoСhemistry">Урал</span>
                <?php endif; ?>
                <?php if(isset($товары_в_категориях[$товар->id]['kamaz']) && $товары_в_категориях[$товар->id]['kamaz']): ?>
                    <span data-category="autoСhemistry">Урал</span>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        </div>
    </div>
</td>
            <!-- Добавление картинки/обработка добавленных -->
            <td>
                <input type="file" class="imageUpload" data-товар-id="<?php echo e($товар->id); ?>" name="image">
                <?php if(isset($товары_в_категориях[$товар->id]) && $товары_в_категориях[$товар->id]['hasImage']): ?>
                    <span>✅</span>
                <?php endif; ?>
            </td>


        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
        </table>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Обработчик для кнопки импорта (вне модального окна)
            const importNomenclatureBtnOutside = document.getElementById('importNomenclatureBtnOutside');
            if (importNomenclatureBtnOutside) {
                importNomenclatureBtnOutside.addEventListener('click', function() {
                    console.log('Кнопка импорта нажата!');
                    fetch('/importNomenclature', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => {
                            console.log('Ответ сервера:', response);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Данные от сервера:', data);
                            if (data.status === 'success') {
                                console.log('Номенклатура успешно импортирована!');
                            } else {
                                console.error('Ошибка при импорте номенклатуры:', data.message);
                                alert('Ошибка при импорте номенклатуры: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Ошибка сети:', error);
                            alert('Ошибка сети при импорте номенклатуры: ' + error.message);
                        });
                });
            }
        });
    </script>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>

</html><?php /**PATH C:\OSPanel\home\katalog.local\resources\views/bd.blade.php ENDPATH**/ ?>