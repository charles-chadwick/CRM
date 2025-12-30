<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_type_id')
                ->nullable()
                ->constrained('company_types')
                ->onDelete('set null');
            $table->string('name');
            $table->text('notes')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by_id')
                ->default(1);
            $table->foreignId('updated_by_id')
                ->nullable()
                ->default(1);
            $table->foreignId('deleted_by_id')
                ->nullable()
                ->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('companies');
    }
};
