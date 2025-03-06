<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('meals', function (Blueprint $table) {
        $table->string('image')->nullable(); // Path to the image
        $table->decimal('price', 8, 2)->nullable(); // Meal price
    });
}

public function down()
{
    Schema::table('meals', function (Blueprint $table) {
        $table->dropColumn(['image', 'price']);
    });
}
};
