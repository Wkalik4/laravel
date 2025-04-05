<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function importNomenclature()
    {
        Log::info('Импорт номенклатуры запущен');

        // Замените на ваши логин и пароль
        $username = "odata.OOOTRI-M43002261@yandex.ru";
        $password = "4i&5%-q4V' j";

        // Создаем строку аутентификации и кодируем ее
        $auth_string = $username . ":" . $password;
        $encoded_auth = base64_encode($auth_string);

        $headers = [
            "Authorization: Basic " . $encoded_auth,
            // Убираем Content-Type: application/json (пока что)
        ];

        // Функция для получения данных
        function fetchData($url, $headers) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Отключаем проверку SSL (ВНИМАНИЕ! небезопасно в production)
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                Log::error('Ошибка curl: ' . curl_error($ch));
                return null;
            }

            curl_close($ch);
            return $response;
        }

        // URL для номенклатуры
        $nomenclature_url = "https://1cfresh.com/a/sbm/3175593/odata/standard.odata/Catalog_%D0%9D%D0%BE%D0%BC%D0%B5%D0%BD%D0%BA%D0%BB%D0%B0%D1%82%D1%83%D1%80%D0%B0?\$select=Ref_Key,Description,%D0%9D%D0%B0%D0%B8%D0%BC%D0%B5%D0%BD%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5%D0%9F%D0%BE%D0%BB%D0%BD%D0%BE%D0%B5&\$format=json";

        // URL для цен
        $prices_url = "https://1cfresh.com/a/sbm/3175593/odata/standard.odata/InformationRegister_%D0%A6%D0%B5%D0%BD%D1%8B%D0%9D%D0%BE%D0%BC%D0%B5%D0%BD%D0%BA%D0%BB%D0%B0%D1%82%D1%83%D1%80%D1%8B?\$select=%D0%9D%D0%BE%D0%BC%D0%B5%D0%BD%D0%BA%D0%BB%D0%B0%D1%82%D1%83%D1%80%D0%B0_Key,%D0%92%D0%B8%D0%B4%D0%A6%D0%B5%D0%BD_Key,%D0%A6%D0%B5%D0%BD%D0%B0,%D0%90%D0%BA%D1%82%D1%83%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D1%8C&\$format=json";

        // Получаем данные о номенклатуре
        $nomenclature_data = fetchData($nomenclature_url, $headers);
        $nomenclatures = json_decode($nomenclature_data, true);

        // Получаем данные о ценах
        $prices_data = fetchData($prices_url, $headers);
        $prices = json_decode($prices_data, true);

        // Массив для хранения объединенных данных
        $combined_data = [];

        // Проверяем, что данные о номенклатуре и ценах получены и имеют правильный формат
        if (isset($nomenclatures['value']) && is_array($nomenclatures['value']) && isset($prices['value']) && is_array($prices['value'])) {
            // Перебираем элементы номенклатуры
            foreach ($nomenclatures['value'] as $nomenclature_item) {
                $found_price = false; // Флаг, чтобы не искать цену для одной номенклатуры несколько раз

                // Перебираем элементы цен
                foreach ($prices['value'] as $price_item) {
                    // Сравниваем ключи
                    if ($nomenclature_item['Ref_Key'] === $price_item['Номенклатура_Key']) {
                        // Формируем объект
                        $combined_item = [
                            "Description" => $nomenclature_item['Description'],
                            "НаименованиеПолное" => $nomenclature_item['НаименованиеПолное'],
                            "Номенклатура_Key" => $price_item['Номенклатура_Key'],
                            "ВидЦен_Key" => $price_item['ВидЦен_Key'],
                            "Цена" => $price_item['Цена'],
                            "Актуальность" => $price_item['Актуальность']
                        ];

                        // Добавляем объект в массив
                        $combined_data[] = $combined_item;
                        $found_price = true; // Устанавливаем флаг, что цена для этой номенклатуры найдена
                    }
                }

            }

            // Теперь, когда у нас есть объединенные данные, мы можем сверить и вставить их в таблицу товары
            $importedCount = 0;
            foreach ($combined_data as $item) {
                try {
                    // Проверяем, существует ли запись с таким Номенклатура_Key в базе данных
                    $existing_record = DB::table('товары')
                        ->where('номенклатура_key', $item['Номенклатура_Key'])
                        ->first();

                    $data = [
                        'description' => $item['Description'],
                        'наименование_полное' => $item['НаименованиеПолное'],
                        'номенклатура_key' => $item['Номенклатура_Key'],
                        'видцен_key' => $item['ВидЦен_Key'],
                        'цена' => $item['Цена'],
                        'актуальность' => $item['Актуальность']
                        // Добавьте другие поля, если они есть в вашей таблице и должны быть заполнены
                    ];

                    if (!$existing_record) {
                        // Записи не существует, создаем новую
                        DB::table('товары')->insert($data);
                        Log::info("Запись успешно создана для " . $item['Description'] . " (Новый товар)");
                    } else {
                        // Запись существует, обновляем
                         DB::table('товары')
                             ->where('номенклатура_key', $item['Номенклатура_Key'])
                             ->update($data);
                        Log::info("Запись успешно обновлена для " . $item['Description']);

                    }
                    $importedCount++;

                } catch (\Exception $e) {
                    Log::error("Ошибка при создании/обновлении записи для " . $item['Description'] . ": " . $e->getMessage());
                }
            }

            Log::info("Импортировано/обновлено $importedCount записей.");
            Log::info('Данные для JSON: ' . print_r($combined_data, true));
            return response()->json(['status' => 'success', 'message' => "Номенклатура успешно импортирована. Обновлено/добавлено $importedCount записей."]);

        } else {
            $message = 'Не удалось получить данные о номенклатуре или ценах.';
            Log::error($message);
            return response()->json(['status' => 'error', 'message' => $message], 500);
        }
    }
}