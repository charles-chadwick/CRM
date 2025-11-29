<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('on');
            $table->unsignedBigInteger('on_id');
            $table->string('type');
            $table->string('phone')
                ->nullable();
            $table->string('fax')
                ->nullable();
            $table->string('email')
                ->nullable();
            $table->string('address_1')
                ->nullable();
            $table->string('address_2')
                ->nullable();
            $table->string('city')
                ->nullable();
            $table->string('state')
                ->nullable();
            $table->string('postal_code')
                ->nullable();
            $table->string('country')
                ->nullable();
            $table->text('notes')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('contacts');
    }
};
