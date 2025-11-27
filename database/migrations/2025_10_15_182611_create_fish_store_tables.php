<?php
// database/migrations/2024_01_01_000001_create_fish_store_tables.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fish', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->integer('stock')->default(0);
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('selling_price', 10, 2);
            $table->string('tank_location')->nullable();
            $table->enum('health_status', ['sehat', 'sakit', 'karantina'])->default('sehat');
            $table->string('photo')->nullable();
            $table->integer('minimum_stock')->default(5);
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact')->nullable();
            $table->text('address')->nullable();
            $table->decimal('survival_rate', 5, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->integer('purchase_count')->default(0);
            $table->timestamps();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'transfer', 'qris']);
            $table->text('notes')->nullable();
            $table->timestamp('sale_date');
            $table->timestamps();
        });

        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fish_id')->constrained('fish')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fish_id')->constrained('fish')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('transport_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2);
            $table->timestamp('purchase_date');
            $table->timestamps();
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['pakan', 'listrik', 'air_treatment', 'gaji', 'sewa', 'peralatan', 'maintenance', 'lainnya']);
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->timestamp('expense_date');
            $table->timestamps();
        });

        Schema::create('mortality_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fish_id')->constrained('fish')->cascadeOnDelete();
            $table->integer('quantity');
            $table->text('reason')->nullable();
            $table->decimal('loss_amount', 10, 2);
            $table->timestamp('recorded_date');
            $table->timestamps();
        });

        Schema::create('quarantine_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fish_id')->constrained('fish')->cascadeOnDelete();
            $table->integer('quantity');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->text('treatment')->nullable();
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quarantine_records');
        Schema::dropIfExists('mortality_records');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('fish');
    }
};
