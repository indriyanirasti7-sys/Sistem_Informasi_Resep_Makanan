<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();

            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->unique(['user_id', 'recipe_id'], 'uq_rating');

            $table->foreign('user_id', 'fk_rt_user')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('recipe_id', 'fk_rt_recipe')
                ->references('id')->on('recipes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        // CHECK constraint (MySQL 8+)
        try {
            DB::statement('ALTER TABLE ratings ADD CONSTRAINT chk_rating_value CHECK (rating BETWEEN 1 AND 5)');
        } catch (\Exception $e) {
            // Skip kalau MySQL versi lama
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};