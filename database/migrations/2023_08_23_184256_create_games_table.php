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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('console_id')->nullable();
            $table->string('nome', 100);
            $table->text('descricao');
            $table->string('imagem', 200);
            $table->string('desenvolvedora');
            $table->string('data_lancamento', 10);
            $table->timestamps();
            // foreign key console
            $table->foreign('console_id')->references('id')->on('consoles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
