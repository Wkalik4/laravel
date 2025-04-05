<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'товары'; // Имя таблицы
    protected $primaryKey = 'id'; // Первичный ключ - 'id', а не 'номенклатура_key' (как было раньше!)
    public $timestamps = true; // Есть поля created_at и updated_at (теперь есть!)

    // Разрешенные для массового заполнения поля
    protected $fillable = [
        'description',
        'наименование_полное',
        'номенклатура_key',
        'видцен_key',
        'цена',
        'актуальность',
        'category_id', // Добавлено поле category_id
        'img', // Добавлено поле img
    ];
}