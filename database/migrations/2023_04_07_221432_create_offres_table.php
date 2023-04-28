<?php

use App\Models\Offre;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('secteur_id')->nullable();
            $table->string('title');
            $table->string('description');
            $table->string('date_debut');
            $table->string('date_fin');
            $table->decimal('prix', 8, 2)->nullable();
            $table->integer('promo')->nullable();
            $table->string('image');
            $table->String('status')->default(Offre::OFFRE_STATUS_LOADING);
            $table->integer('like')->default(0);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offres');
    }
};
