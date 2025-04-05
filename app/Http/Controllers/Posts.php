<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class Posts extends Controller
{
    
    public function index()
    {
        return view('index',[]);
    }

    public function date(Request $request)
{
    try {
        // Здесь должен быть код для импорта номенклатуры

        // В случае успеха:
        return response()->json(['status' => 'success', 'message' => 'Номенклатура успешно импортирована.']);

        // В случае ошибки:
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Ошибка при импорте номенклатуры: ' . $e->getMessage()], 500);
    }
}




    //добавляет товар из таблицы товары в таблицу oils.
    public function addToOils(Request $request, $товар_id)
    {
        try {
            // Получаем данные товара из таблицы товары
            $товар = DB::table('товары')->find($товар_id);

            if (!$товар) {
                return response()->json(['status' => 'error', 'message' => 'Товар не найден.'], 404);
            }

            // Проверяем, существует ли уже запись с таким номенклатура_key в таблице oils
            $existingOil = DB::table('oils')->where('номенклатура_key', $товар->номенклатура_key)->first();

            if (!$existingOil) {
                // Вставляем данные в таблицу oils
                DB::table('oils')->insert([
                    'номенклатура_key' => $товар->номенклатура_key,
                    'наименование_полное' => $товар->наименование_полное,
                    'description' => $товар->description,
                    'цена' => $товар->цена,
                ]);

                return response()->json(['status' => 'success', 'message' => 'Товар успешно добавлен в oils.']);
            } else {
                return response()->json(['status' => 'info', 'message' => 'Товар уже существует в oils.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Ошибка при добавлении товара: ' . $e->getMessage()], 500);
        }
    }


    //Этот код представляет собой метод bd контроллера, который отвечает за отображение таблицы товаров с информацией о 
    // категориях и изображениях. Он также проверяет, имеет ли пользователь права администратора для просмотра этой страницы.

    public function bd()
{
    // Проверяем, аутентифицирован ли пользователь и имеет ли он роль "admin"
    if (!Auth::check() || !Auth::user()->role || Auth::user()->role->name !== 'admin') {
        abort(403, 'У вас нет прав для просмотра этой страницы.'); // Возвращаем ошибку 403, если нет прав
    }

    // Если пользователь - администратор, продолжаем выполнение кода
    $товары = DB::table('товары')
        ->select('id', 'наименование_полное', 'description', 'цена', 'номенклатура_key', 'img') // Получаем поле img
        ->get();

    $товары_в_категориях = [];
    foreach ($товары as $товар) {
        $selectedCategory = null;
        if (DB::table('oils')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'масла';
        } elseif (DB::table('tools')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'tools';
        } elseif (DB::table('fasteners')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'fasteners';
        } elseif (DB::table('mtz')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'mtz';
        }elseif (DB::table('gazel')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'gazel';
        }elseif (DB::table('autoСhemistry')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'autoСhemistry';
        }elseif (DB::table('autoVaz')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'autoVaz';
        }elseif (DB::table('ural')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'ural';
        }elseif (DB::table('kamaz')->where('номенклатура_key', $товар->номенклатура_key)->exists()) {
            $selectedCategory = 'kamaz';
        }


        $товары_в_категориях[$товар->id] = [
            'масла' => DB::table('oils')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'tools' => DB::table('tools')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'fasteners' => DB::table('fasteners')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'mtz' => DB::table('mtz')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'gazel' => DB::table('gazel')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'autoСhemistry' => DB::table('autoСhemistry')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'autoVaz' => DB::table('autoVaz')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'ural' => DB::table('ural')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'kamaz' => DB::table('kamaz')->where('номенклатура_key', $товар->номенклатура_key)->exists(),
            'hasImage' => !empty($товар->img),
            'selectedCategory' => $selectedCategory, // Добавляем информацию о выбранной категории
        ];
    }

    return view('bd', ['товары' => $товары, 'товары_в_категориях' => $товары_в_категориях]);
}




public function saveCategory(Request $request, $товар_id)
{
    $validatedData = $request->validate([
        'category_id' => 'required|string', // Изменили на string
    ]);

    $category_id = $validatedData['category_id'];

    try {
        // Получаем данные товара из таблицы товары
        $товар = DB::table('товары')->find($товар_id);

        if (!$товар) {
            return response()->json(['status' => 'error', 'message' => 'Товар не найден.'], 404);
        }

        $tableName = null; // Имя таблицы для вставки

        switch ($category_id) {
            case 'масла':
                $tableName = 'oils';
                break;
            case 'tools':
                $tableName = 'tools';
                break;
            case 'fasteners':
                $tableName = 'fasteners';
                break;
            case 'mtz':
                $tableName = 'mtz';
                break;
            case 'gazel':
                $tableName = 'gazel';
                break;
            case 'autoСhemistry':
                $tableName = 'autoСhemistry';
                break;
            case 'autoVaz':
                $tableName = 'autoVaz';
                break;
            case 'ural':
                $tableName = 'ural';
                break;
            case 'kamaz':
                $tableName = 'kamaz';
                break;
            default:
                return response()->json(['status' => 'info', 'message' => 'Категория  не выбрана']);
        }

        if ($tableName) {
            // Проверяем, существует ли уже запись с таким номенклатура_key в таблице
            $existingRecord = DB::table($tableName)->where('номенклатура_key', $товар->номенклатура_key)->first();

            if (!$existingRecord) {
                // Вставляем данные в таблицу
                DB::table($tableName)->insert([
                    'номенклатура_key' => $товар->номенклатура_key,
                    'наименование_полное' => $товар->наименование_полное,
                    'description' => $товар->description,
                    'цена' => $товар->цена,
                ]);

                return response()->json(['status' => 'success', 'message' => 'Товар успешно добавлен в ' . $category_id . '.']);
            } else {
                return response()->json(['status' => 'info', 'message' => 'Товар уже существует в ' . $category_id . '.']);
            }
        }

        return response()->json(['status' => 'info', 'message' => 'Категория не выбрана']);

    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Ошибка: ' . $e->getMessage()], 500);
    }
}





    public function saveImage(Request $request, $товар_id)
    {
        try {
            // Получаем данные товара из таблицы товары
            $товар = DB::table('товары')->find($товар_id);
    
            if (!$товар) {
                return response()->json(['status' => 'error', 'message' => 'Товар не найден.'], 404);
            }
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('img/categorii'); // Общая папка для всех изображений
    
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
    
                $image->move($path, $filename);
                $imagePath = 'img/categorii/' . $filename;
            } else {
                return response()->json(['status' => 'error', 'message' => 'Изображение не выбрано.'], 400);
            }
    
            // Обновляем запись в таблице товары
            DB::table('товары')
                ->where('id', $товар->id)
                ->update(['img' => $imagePath]);
    
            return response()->json(['status' => 'success', 'message' => 'Изображение успешно сохранено.']);
    
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Ошибка: ' . $e->getMessage()], 500);
        }
    }
}