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
        Schema::create('cheque_garanties', function (Blueprint $table) {
            $table->increments('id');
            $table->date('cheque_echeance');
            $table->string('cheque_number', 255);
            $table->decimal('amount', 10, 2);
            $table->string('cheque_status')->default('Activate');
            $table->date('cheque_dateP');
            $table->timestamps();
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheque_garanties');
    }
};
