<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

    films
    showrooms
    Shows
    bookings
    seats
    seat_types


     **Movie exploration**
     * As a user I want to see which films can be watched and at what times **shows**
     * As a user I want to only see the shows which are not booked out **bookings**

     **Show administration**
     * As a cinema owner I want to run different films at different times **shows**
     * As a cinema owner I want to run multiple films at the same time in different showrooms **shows**

     **Pricing**
     * As a cinema owner I want to get paid differently per show **shows**
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat **seats**

     **Seating**
     * As a user I want to book a seat **bookings**
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        Schema::create('films', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->text('about');
            $table->string('type');
            $table->string('duration');
            $table->date('release_date');
            $table->string('main_image');
            $table->string('cover_image');
            $table->timestamps();
        });


        Schema::create('showrooms', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('total_capacity');
            $table->integer('base_price');
            $table->timestamps();
        });

        Schema::create('seat_types', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('premium_percentage');
            $table->timestamps();
        });

        Schema::create('seats', function ($table) {
            $table->increments('id');

            $table->integer('showroom_id')->unsigned();
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');

            $table->integer('seat_type_id')->unsigned()->nullable();
            $table->foreign('seat_type_id')->references('id')->on('seat_types')->onDelete('cascade');

            $table->string('seat_number');
            $table->string('row_number');

            $table->timestamps();
        });

        Schema::create('shows', function ($table) {
            $table->increments('id');

            $table->integer('film_id')->unsigned();
            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');

            $table->integer('showroom_id')->unsigned();
            $table->foreign('showroom_id')->references('id')->on('showrooms')->onDelete('cascade');

            $table->datetime('time');
            $table->timestamps();
        });


        Schema::create('bookings', function ($table) {
            $table->increments('id');

            $table->integer('show_id')->unsigned();
            $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');

            $table->integer('seat_id')->unsigned();
            $table->foreign('seat_id')->references('id')->on('seats')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
