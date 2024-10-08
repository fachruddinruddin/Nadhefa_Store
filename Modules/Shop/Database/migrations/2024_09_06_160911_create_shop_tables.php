<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTables extends Migration
{
    public function up()
    {
        // Modify users table if it exists
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'last_login_at')) {
                    $table->dateTime('last_login_at')->nullable();
                }
                if (!Schema::hasColumn('users', 'last_login_ip_address')) {
                    $table->string('last_login_ip_address')->nullable();
                }
            });
        }

        // Shop addresses table
        Schema::create('shop_addresses', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36);
            $table->boolean('is_primary')->default(false);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->integer('postcode')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });

        // Shop attributes table
        Schema::create('shop_attributes', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('code');
            $table->string('name');
            $table->string('attribute_type');
            $table->string('validation_rules')->nullable();
            $table->timestamps();
        });

        // Shop attribute options table
        Schema::create('shop_attribute_options', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('attribute_id', 36);
            $table->string('slug');
            $table->string('name');
            $table->timestamps();

            $table->index('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('shop_attributes');
        });

        // Shop categories table
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('parent_id', 36)->nullable();
            $table->string('slug');
            $table->string('name');
            $table->timestamps();

            $table->unique(['slug', 'parent_id']);
            $table->index('created_at');
            $table->index('parent_id');
        });

        // Shop products table
        Schema::create('shop_products', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36);
            $table->string('sku');
            $table->string('type');
            $table->char('parent_id', 36)->nullable();
            $table->string('name');
            $table->string('slug');
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->string('status');
            $table->string('stock_status')->default('IN_STOCK');
            $table->boolean('manage_stock')->default(false);
            $table->dateTime('publish_date')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('body')->nullable();
            $table->json('metas')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['sku', 'parent_id']);
            $table->index('user_id');
            $table->index('parent_id');
            $table->index('publish_date');

            $table->foreign('user_id')->references('id')->on('users');
        });

        // Shop categories products pivot table
        Schema::create('shop_categories_products', function (Blueprint $table) {
            $table->char('product_id', 36);
            $table->char('category_id', 36);

            $table->primary(['product_id', 'category_id']);
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('category_id')->references('id')->on('shop_categories');
        });

        // Shop product attributes table
        Schema::create('shop_product_attributes', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('product_id', 36);
            $table->char('attribute_id', 36);
            $table->string('string_value')->nullable();
            $table->text('text_value')->nullable();
            $table->boolean('boolean_value')->nullable();
            $table->integer('integer_value')->nullable();
            $table->decimal('float_value', 8, 2)->nullable();
            $table->dateTime('datetime_value')->nullable();
            $table->date('date_value')->nullable();
            $table->text('json_value')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('shop_attributes')->onDelete('cascade');
        });

        // Shop product inventories table
        Schema::create('shop_product_inventories', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('product_id', 36);
            $table->char('product_attribute_id', 36)->nullable();
            $table->integer('qty')->nullable();
            $table->integer('low_stock_threshold')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('shop_products')->onDelete('cascade');
            $table->foreign('product_attribute_id')->references('id')->on('shop_product_attributes')->onDelete('cascade');
        });

        // Shop orders table
        Schema::create('shop_orders', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36);
            $table->string('code')->unique();
            $table->string('status');
            $table->char('approved_by', 36)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->char('cancelled_by', 36)->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->text('cancellation_note')->nullable();
            $table->dateTime('order_date');
            $table->dateTime('payment_due');
            $table->string('payment_status');
            $table->decimal('base_total_price', 16, 2)->default(0);
            $table->decimal('tax_amount', 16, 2)->default(0);
            $table->decimal('tax_percent', 16, 2)->default(0);
            $table->decimal('discount_amount', 16, 2)->default(0);
            $table->decimal('discount_percent', 16, 2)->default(0);
            $table->decimal('shipping_cost', 16, 2)->default(0);
            $table->decimal('grand_total', 16, 2)->default(0);
            $table->text('customer_note')->nullable();
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('customer_address1')->nullable();
            $table->string('customer_address2')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_province')->nullable();
            $table->integer('customer_postcode')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('code');
            $table->index(['code', 'order_date']);
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');
            $table->foreign('cancelled_by')->references('id')->on('users');
        });

        // Shop order items table
        Schema::create('shop_order_items', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('order_id', 36);
            $table->char('product_id', 36);
            $table->integer('qty');
            $table->decimal('base_price', 16, 2)->default(0);
            $table->decimal('base_total', 16, 2)->default(0);
            $table->decimal('tax_amount', 16, 2)->default(0);
            $table->decimal('tax_percent', 16, 2)->default(0);
            $table->decimal('discount_amount', 16, 2)->default(0);
            $table->decimal('discount_percent', 16, 2)->default(0);
            $table->decimal('sub_total', 16, 2)->default(0);
            $table->string('sku');
            $table->string('type');
            $table->string('name');
            $table->json('attributes');
            $table->timestamps();

            $table->index('sku');
            $table->foreign('order_id')->references('id')->on('shop_orders');
            $table->foreign('product_id')->references('id')->on('shop_products');
        });

        // Shop payments table
        Schema::create('shop_payments', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36);
            $table->char('order_id', 36);
            $table->string('payment_type');
            $table->string('status');
            $table->char('approved_by', 36)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->text('note')->nullable();
            $table->char('rejected_by', 36)->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->text('rejection_note')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->json('payloads')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('payment_type');
            $table->index('user_id');
            $table->index('order_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_id')->references('id')->on('shop_orders');
        });

        // Shop tags table
        Schema::create('shop_tags', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('slug')->unique();
            $table->string('name');
            $table->timestamps();

            $table->index('created_at');
        });

        // Shop products tags pivot table
        Schema::create('shop_products_tags', function (Blueprint $table) {
            $table->char('product_id', 36);
            $table->char('tag_id', 36);

            $table->primary(['product_id', 'tag_id']);
            $table->foreign('product_id')->references('id')->on('shop_products');
            $table->foreign('tag_id')->references('id')->on('shop_tags');
        });

        // Shop carts table
        Schema::create('shop_carts', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('user_id', 36)->nullable();
            $table->dateTime('expired_at');
            $table->decimal('base_total_price', 16, 2)->default(0);
            $table->decimal('tax_amount', 16, 2)->default(0);
            $table->decimal('tax_percent', 16, 2)->default(0);
            $table->decimal('discount_amount', 16, 2)->default(0);
            $table->decimal('discount_percent', 16, 2)->default(0);
            $table->decimal('grand_total', 16, 2)->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index('user_id');
            $table->index('expired_at');
            $table->foreign('user_id')->references('id')->on('users');
        });

        // Shop cart items table
        Schema::create('shop_cart_items', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('cart_id', 36);
            $table->char('product_id', 36);
            $table->integer('qty');
            $table->timestamps();

            $table->foreign('cart_id')->references('id')->on('shop_carts');
            $table->foreign('product_id')->references('id')->on('shop_products');
        });
    }

    public function down()
    {
        // Drop all created tables
        Schema::dropIfExists('shop_cart_items');
        Schema::dropIfExists('shop_carts');
        Schema::dropIfExists('shop_products_tags');
        Schema::dropIfExists('shop_tags');
        Schema::dropIfExists('shop_payments');
        Schema::dropIfExists('shop_order_items');
        Schema::dropIfExists('shop_orders');
        Schema::dropIfExists('shop_product_inventories');
        Schema::dropIfExists('shop_product_attributes');
        Schema::dropIfExists('shop_categories_products');
        Schema::dropIfExists('shop_products');
        Schema::dropIfExists('shop_categories');
        Schema::dropIfExists('shop_attribute_options');
        Schema::dropIfExists('shop_attributes');
        Schema::dropIfExists('shop_addresses');

        // Remove added columns from users table
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('last_login_at');
                $table->dropColumn('last_login_ip_address');
            });
        }
    }
}
