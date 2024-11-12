<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Siparişin benzersiz ID'si
            $table->unsignedBigInteger('user_id'); // Kullanıcı ID'si (foreign key)
            $table->unsignedBigInteger('product_id'); // Ürün ID'si (foreign key)
            $table->integer('quantity'); // Sipariş edilen ürün miktarı
            $table->decimal('total_price', 10, 2); // Toplam fiyat
            $table->string('status')->default('pending'); // Siparişin durumu (varsayılan: pending)
            $table->timestamps(); // Created_at ve updated_at sütunları

            // Foreign key ilişkileri
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

