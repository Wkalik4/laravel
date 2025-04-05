<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function oils()
{
    $products = DB::table('oils')
        ->leftJoin('Товары', 'oils.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'oils.наименование_полное as наименование_полное',
            'oils.description as description',
            'oils.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.oils', ['products' => $products]);
}
public function tools()
{
    // Получаем данные из таблицы "tools"
    $products = DB::table('tools')
        ->leftJoin('Товары', 'tools.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'tools.наименование_полное as наименование_полное',
            'tools.description as description',
            'tools.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.tools', ['products' => $products]);
}



public function fasteners()
{
    // Получаем данные из таблицы "fasteners"
    $products = DB::table('fasteners')
        ->leftJoin('Товары', 'fasteners.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'fasteners.наименование_полное as наименование_полное',
            'fasteners.description as description',
            'fasteners.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.fasteners', ['products' => $products]);
}

public function mtz()
{
    $products = DB::table('mtz')
        ->leftJoin('Товары', 'mtz.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'mtz.наименование_полное as наименование_полное',
            'mtz.description as description',
            'mtz.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.mtz', ['products' => $products]);
}

public function gazel()
{
    $products = DB::table('gazel')
        ->leftJoin('Товары', 'gazel.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'gazel.наименование_полное as наименование_полное',
            'gazel.description as description',
            'gazel.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.gazel', ['products' => $products]);
}

public function autoСhemistry()
{
    $products = DB::table('autoСhemistry')
        ->leftJoin('Товары', 'autoСhemistry.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'autoСhemistry.наименование_полное as наименование_полное',
            'autoСhemistry.description as description',
            'autoСhemistry.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.autoСhemistry', ['products' => $products]);
}



public function autoVaz()
{
    $products = DB::table('autoVaz')
        ->leftJoin('Товары', 'autoVaz.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'autoVaz.наименование_полное as наименование_полное',
            'autoVaz.description as description',
            'autoVaz.цена as цена',
            'Товары.img as img',
            'Товары.id as id', // Важно! Добавляем id
            'Товары.category_id AS category_id' // И category_id (Используем AS)
        )
        ->get();

    return view('categories.autoVaz', ['products' => $products]); // Используем правильное название view и переменной
}


public function ural()
{
    $products = DB::table('ural')
        ->leftJoin('Товары', 'ural.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'ural.наименование_полное as наименование_полное',
            'ural.description as description',
            'ural.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.ural', ['products' => $products]);
}

public function kamaz()
{
    $products = DB::table('kamaz')
        ->leftJoin('Товары', 'kamaz.номенклатура_key', '=', 'Товары.номенклатура_key')
        ->select(
            'kamaz.наименование_полное as наименование_полное',
            'kamaz.description as description',
            'kamaz.цена as цена',
            'Товары.img as img'
        )
        ->get();

    return view('categories.kamaz', ['products' => $products]);
}
}