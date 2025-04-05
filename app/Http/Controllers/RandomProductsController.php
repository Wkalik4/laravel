<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RandomProductsController extends Controller
{
    public function index()
    {
        
        $fasteners = DB::table('fasteners')
            ->leftJoin('Товары', 'fasteners.номенклатура_key', '=', 'Товары.номенклатура_key')
            ->select(
                'fasteners.наименование_полное as наименование_полное',
                'fasteners.description as description',
                'fasteners.цена as цена',
                'Товары.img as img'
            )
            ->inRandomOrder()
            ->limit(7) // Максимум 7 крепежей
            ->get();

        $oils = DB::table('oils')
            ->leftJoin('Товары', 'oils.номенклатура_key', '=', 'Товары.номенклатура_key')
            ->select(
                'oils.наименование_полное as наименование_полное',
                'oils.description as description',
                'oils.цена as цена',
                'Товары.img as img'
            )
            ->inRandomOrder()
            ->limit(7) // Максимум 7 масел
            ->get();

        $tools = DB::table('tools')
            ->leftJoin('Товары', 'tools.номенклатура_key', '=', 'Товары.номенклатура_key')
            ->select(
                'tools.наименование_полное as наименование_полное',
                'tools.description as description',
                'tools.цена as цена',
                'Товары.img as img'
            )
            ->inRandomOrder()
            ->limit(6) // Максимум 6 инструментов
            ->get();

        // Объединяем все результаты в один массив
        $products = $fasteners->concat($oils)->concat($tools)->shuffle();

        // Берем только первые 20 элементов (или меньше, если их меньше 20)
        $products = $products->take(20);

        return view('index', ['products' => $products]); // Исправлено!
    }
}