<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();//le pertenece un usuario, no negativo 
            $table->integer('category_id')->unsigned();

            $table->string('name',128);
            $table->string('slug',128)->unique();//rastro del flujo -URL AMIGABLE
            $table->mediumText('excerpt')->nullable();//extracto
            $table->text('body');
            $table->enum('status',['PUBLISHED','DRAFT'])->default('DRAFT');//SE PUEDE GRARDAR  DOS VALORES Y POR DEFECTO ES DRAFT
            $table->string('file',128)->nullable();

            $table->timestamps();
            //Relation
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade'); //Si elimina una category... elimina los post que estan relacionados 

           /* $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
