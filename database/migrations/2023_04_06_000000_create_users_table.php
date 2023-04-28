<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profession_id')->nullable();
            $table->unsignedBigInteger('ville_id');
            $table->unsignedBigInteger('specialite_id')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('carte_id')->nullable();
            $table->unsignedBigInteger('secteur_id')->nullable();
            $table->unsignedBigInteger('gouvernerat_id');
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('nom_responsable')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image');
            $table->integer('cin');
            $table->integer('numero');
            $table->string('adresse');
            $table->boolean('is_first_time')->default(true);
            $table->foreign('profession_id')
                ->references('id')
                ->on('professions');
            $table->foreign('gouvernerat_id')
                ->references('id')
                ->on('gouvernerats');
            $table->foreign('specialite_id')
                ->references('id')
                ->on('specialites');


            $table->foreign('ville_id')
                ->references('id')
                ->on('villes');


            $table->foreign('carte_id')
                ->references('id')
                ->on('cartes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('secteur_id')
                ->references('id')
                ->on('secteurs')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
