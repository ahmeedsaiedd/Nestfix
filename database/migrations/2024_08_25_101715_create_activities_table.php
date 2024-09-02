<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (Schema::hasColumn('activities', 'closed_at')) {
                $table->dropColumn('closed_at');
            }
        });
    }

    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            if (!Schema::hasColumn('activities', 'closed_at')) {
                $table->timestamp('closed_at')->nullable();
            }
        });
    }
};
