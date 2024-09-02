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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('trace_id');
            $table->string('provider_name');
            $table->string('issue_category');
            $table->text('issue_description');
            $table->string('assigned_to')->nullable();
            $table->string('priority')->nullable(); // Ensure priority column is nullable
            $table->string('status')->nullable();
            $table->string('test')->nullable();
            $table->string('environment')->nullable();
            $table->string('attachments')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('solved_at')->nullable();
            $table->text('comment')->nullable();
            $table->string('created_by')->nullable();
            // New column to track the user who created the ticket

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Drop foreign key constraint before dropping the column
            $table->dropForeign(['created_by']);
        });

        Schema::dropIfExists('tickets');
    }
};
