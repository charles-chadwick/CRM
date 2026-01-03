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
        Schema::create('sales_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->nullable()
                ->constrained('companies')
                ->onDelete('set null');
            $table->string('type');
            $table->string('status');
            $table->string('title');
            $table->text('notes')
                ->nullable();
            $table->timestamp('contacted_at');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by_id')
                ->default(1);
            $table->unsignedBigInteger('updated_by_id')
                ->nullable()
                ->default(1);
            $table->unsignedBigInteger('deleted_by_id')
                ->nullable()
                ->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('sales_leads');
    }
};
