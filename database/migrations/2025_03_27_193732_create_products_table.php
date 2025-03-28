<?php

use App\Models\Category;
use App\Models\Provider;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name",30);
            $table->double("price");
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete()->cascadeOnDelete();
            $table->foreignIdFor(Provider::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger("quantity")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
