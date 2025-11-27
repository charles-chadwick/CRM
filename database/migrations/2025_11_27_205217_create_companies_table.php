<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->text('notes')
                ->nullable();
            $table->integer('created_by_id');
            $table->integer('updated_by_id')
                ->nullable();
            $table->integer('deleted_by_id')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('companies');
    }
};
