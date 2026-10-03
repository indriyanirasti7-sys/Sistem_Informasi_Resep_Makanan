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
         Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->decimal('amount', 8, 2);
            $table->string('unit', 20)->nullable();

            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->unique(['recipe_id', 'ingredient_id'], 'uq_recipe_ing');

            $table->foreign('recipe_id', 'fk_ri_recipe')
                ->references('id')->on('recipes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('ingredient_id', 'fk_ri_ingredient')
                ->references('id')->on('ingredients')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_ingredients');
    }
};
