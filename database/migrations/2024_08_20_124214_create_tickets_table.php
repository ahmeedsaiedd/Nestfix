<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('trace_id');
            $table->string('provider_name');
            $table->string('issue_category');
            $table->text('issue_description');
            $table->string('assigned_to');
            $table->string('priority');
            $table->string('status');
            $table->text('attachment')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
            $table->text('comment')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
