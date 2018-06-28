<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablesBlameable extends Migration
{
    protected $tables = [
        'entities',
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $tablename) {
            Schema::table($tablename, function (Blueprint $table) {
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->unsignedInteger('deleted_by')->nullable();

                /**
                 * You can also create foreign key constrains
                 * for the blameable attributes.
                 */
                $table->foreign('created_by')
                    ->references('id')->on('users')
                    ->onDelete('cascade');

                $table->foreign('updated_by')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
