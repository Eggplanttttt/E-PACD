<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('complaint_solved', function (Blueprint $table) {
            $table->string('sent_to')->after('video')->nullable();
            $table->date('sent_date')->after('sent_to')->nullable();
            $table->text('action_taken')->after('sent_date')->nullable();
            $table->date('action_date')->after('action_taken')->nullable();
        });
    }

    public function down()
    {
        Schema::table('complaint_solved', function (Blueprint $table) {
            $table->dropColumn([
                'sent_to',
                'sent_date',
                'action_taken',
                'action_date'
            ]);
        });
    }
};
