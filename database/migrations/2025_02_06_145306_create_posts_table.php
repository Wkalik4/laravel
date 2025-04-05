<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('товары', function (Blueprint $table) {
            $table->id(); // auto_increment, primary key
            $table->string('description', 255);
            $table->string('наименование_полное', 255)->nullable();
            $table->string('номенклатура_key', 36)->nullable()->unique();
            $table->string('видцен_key', 36)->nullable()->unique();
            $table->decimal('цена', 10, 2)->nullable(); // 10 цифр, 2 после запятой
            $table->tinyInteger('актуальность')->nullable();
            $table->timestamps();  // Добавляет created_at и updated_at (если нужно)
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
?>
