<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * 계시판 목록
     */
    public function up(): void
    {
        Schema::create('site_board', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('enable')->nullable();

            // 분류코드
            $table->string('code')->nullable();
            $table->string('slug')->nullable(); // url 임시코드

            //
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();

            // board 대표 이미지
            $table->string('image')->nullable();

            $table->text('header')->nullable();
            $table->text('footer')->nullable();

            // Blade
            //$table->string('blade')->nullable();
            $table->string('view_layout')->nullable();
            $table->string('view_table')->nullable();
            $table->string('view_list')->nullable();
            $table->string('view_filter')->nullable();
            $table->string('view_create')->nullable();
            $table->string('view_detail')->nullable();
            $table->string('view_edit')->nullable();
            $table->string('view_form')->nullable();



            $table->string('manager')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_board');
    }
};
