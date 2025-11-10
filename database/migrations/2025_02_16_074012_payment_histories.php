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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('amount_money')->nullable();
            $table->string('card_number',30)->nullable();
            $table->string('TransactionStatus')->default(1);
            $table->string('BankCode')->nullable();
            $table->string('TransactionNo')->nullable();
            $table->string('payment_status')->nullable()->comment("0:chưa thanh toán, 1:đã thanh toán,  2:Hủy");
            $table->string('vnp_BankTranNo')->nullable();
            $table->string('vnp_ResponseCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
