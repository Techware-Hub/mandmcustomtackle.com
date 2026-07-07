<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (! Schema::hasColumn('categories', 'image')) {
                $table->string('image')->nullable()->after('description');
            }
            if (! Schema::hasColumn('categories', 'status')) {
                $table->string('status')->default('active')->index()->after('accent');
            }
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('blog_posts', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('slug');
            }
            if (! Schema::hasColumn('blog_posts', 'status')) {
                $table->string('status')->default('published')->index()->after('body');
            }
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            if (! Schema::hasColumn('gallery_items', 'status')) {
                $table->string('status')->default('active')->index()->after('color');
            }
        });

        Schema::table('testimonials', function (Blueprint $table) {
            if (! Schema::hasColumn('testimonials', 'rating')) {
                $table->unsignedTinyInteger('rating')->default(5)->after('location');
            }
            if (! Schema::hasColumn('testimonials', 'status')) {
                $table->string('status')->default('active')->index()->after('quote');
            }
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_messages', 'read_at')) {
                $table->timestamp('read_at')->nullable()->after('message');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            foreach (['image', 'status'] as $column) {
                if (Schema::hasColumn('categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            foreach (['featured_image', 'status'] as $column) {
                if (Schema::hasColumn('blog_posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('gallery_items', function (Blueprint $table) {
            if (Schema::hasColumn('gallery_items', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('testimonials', function (Blueprint $table) {
            foreach (['rating', 'status'] as $column) {
                if (Schema::hasColumn('testimonials', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            if (Schema::hasColumn('contact_messages', 'read_at')) {
                $table->dropColumn('read_at');
            }
        });
    }
};
