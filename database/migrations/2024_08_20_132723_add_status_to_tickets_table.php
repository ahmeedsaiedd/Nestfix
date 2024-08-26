<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->string('assigned_to')->nullable()->after('status'); // Add this field
        $table->timestamp('closed_at')->nullable()->after('assigned_to'); // Add closed_at field
    });
}

public function down()
{
    Schema::table('tickets', function (Blueprint $table) {
        $table->dropColumn('assigned_to');
        $table->dropColumn('closed_at');
    });
}

};
