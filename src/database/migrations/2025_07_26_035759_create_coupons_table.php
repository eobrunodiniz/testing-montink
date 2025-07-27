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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            // tipo de desconto: "fixed" (valor) ou "percent" (%)
            $table->enum('discount_type', ['fixed', 'percent'])->default('fixed');
            // valor ou porcentagem
            $table->decimal('discount_value', 10, 2);
            // valor mínimo de subtotal para aplicar
            $table->decimal('min_subtotal', 10, 2)->default(0);
            // validade
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
