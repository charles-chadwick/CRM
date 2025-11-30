<?php

use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() : void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)
                ->nullable();
            $table->string('title')
                ->nullable();
            $table->string('prefix')
                ->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('suffix')
                ->nullable();
            $table->string('email');
            $table->timestamp('email_verified_at')
                ->nullable();
            $table->string('password');
            $table->string('remember_token')
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
        Schema::dropIfExists('customers');
    }
};
