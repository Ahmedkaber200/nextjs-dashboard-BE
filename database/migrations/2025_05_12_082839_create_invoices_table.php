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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
              // Pehle column create karo
            $table->unsignedBigInteger('customer_id')->nullable(); // Foreign key (self reference or external)
            // Phir us column ko foreign key banao
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');
            $table->decimal('total_amount');
            $table->date('date');
            //  $table->enum('status', ['pending', 'paid']);
            $table->string('status')->nullable()->default('pending');
            $table->json('product_details')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
