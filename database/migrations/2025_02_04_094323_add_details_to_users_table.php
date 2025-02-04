<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->string('nup')->nullable();
            $table->string('department')->nullable();
            $table->string('role')->nullable();
            $table->string('company')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'nup', 'department', 'role', 'company']);
        });
    }
};
