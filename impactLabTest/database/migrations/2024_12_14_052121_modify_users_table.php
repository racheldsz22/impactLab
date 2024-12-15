<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bio', 500)->nullable()->after('email'); // Bio field (max length 500)
            $table->string('url', 2048)->nullable()->after('bio'); // URL field
            $table->enum('role', ['customer', 'admin', 'guest'])->default('customer')->after('url');
            $table->softDeletes(); // Adds 'deleted_at' for soft deletes
            $table->unsignedBigInteger('deleted_by')->nullable()->after('deleted_at'); // Deleted by user ID

            // Add foreign key for 'deleted_by' referencing the same users table
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['deleted_by']);
            $table->dropColumn(['bio', 'url','role', 'deleted_at', 'deleted_by']);

        });
    }
};
