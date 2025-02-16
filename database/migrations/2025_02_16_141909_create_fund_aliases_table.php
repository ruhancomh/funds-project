<?php

use App\Models\Fund;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fund_aliases', function (Blueprint $table) {
            $table->id();
            $table->string('alias');
            $table->foreignIdFor(Fund::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fund_aliases');
    }
};
