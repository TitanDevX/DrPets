<?php

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\PromoCode;
use App\Models\User;
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
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->tinyInteger('status');
            $table->tinyInteger('type');
            $table->double('subtotal');
            $table->double('tax');
            $table->double('fee');
            $table->foreignIdFor(PromoCode::class)->nullable();
            $table->double('total');
            
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_items');
    }
};
