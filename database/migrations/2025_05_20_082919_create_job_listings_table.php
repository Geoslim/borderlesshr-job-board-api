<?php

use App\Models\Company;
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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class);
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->string('salary_range')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->boolean('is_published')->default(false);;
            $table->timestamp('published_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['location', 'is_remote', 'is_published']);
            $table->fullText(['title', 'description']); // fulltext index for keyword search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
