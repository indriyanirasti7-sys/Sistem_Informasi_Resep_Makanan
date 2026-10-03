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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug', 180)->unique();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->text('description')->nullable();
            $table->unsignedTinyInteger('servings')->default(1);
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->enum('difficulty', ['Mudah', 'Sedang', 'Sulit'])->default('Mudah');
            $table->unsignedSmallInteger('calories')->nullable();
            $table->string('image', 255)->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedInteger('views')->default(0);

            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->index('title', 'idx_recipes_title');

            $table->foreign('category_id', 'fk_recipes_category')
                ->references('id')->on('categories')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id', 'fk_recipes_user')
                ->references('id')->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
