<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('photographers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId("user_id")->constrained("users");
            $table->string("location")->nullable();
            $table->string("speciality")->nullable();
            $table->foreignId("profileImage_id")->nullable()->constrained("images")->onDelete("cascade");
            $table->foreignId("bigprofileImage_id")->nullable()->constrained("images")->onDelete("cascade");
            $table->string("phone")->nullable();
            $table->text("bio")->nullable();
            $table->string("instagram")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photographers');
    }
};
