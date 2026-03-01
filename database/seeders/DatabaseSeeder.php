<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        User::truncate();
        Role::truncate();
        DB::table('role_user')->truncate();
        Category::truncate();
        Product::truncate();
        Store::truncate();
        Address::truncate();
        Coupon::truncate();
        Offer::truncate();

        // Create roles
        $adminRole = Role::create(['name' => 'admin', 'description' => 'Administrator with full access']);
        $merchantRole = Role::create(['name' => 'merchant', 'description' => 'Merchant/Seller account']);
        $customerRole = Role::create(['name' => 'customer', 'description' => 'Regular customer account']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@mystar.com',
            'password' => bcrypt('password'),
            'phone' => '+970599000000',
            'address' => 'Gaza, Palestine',
            'city' => 'Gaza',
            'country' => 'Palestine',
            'is_active' => true,
        ]);
        $admin->roles()->attach($adminRole);

        // Create merchant user and store
        $merchant = User::create([
            'name' => 'Merchant User',
            'email' => 'merchant@mystar.com',
            'password' => bcrypt('password'),
            'phone' => '+970599000001',
            'address' => 'Gaza, Palestine',
            'city' => 'Gaza',
            'country' => 'Palestine',
            'is_active' => true,
        ]);
        $merchant->roles()->attach($merchantRole);

        $store = Store::create([
            'name' => 'My Star Store',
            'slug' => 'my-star-store',
            'description' => 'Your one-stop shop for all your needs',
            'address' => 'Gaza, Palestine',
            'phone' => '+970599000001',
            'email' => 'store@mystar.com',
            'user_id' => $merchant->id,
            'is_active' => true,
            'is_verified' => true,
            'rating' => 4.5,
        ]);

        // Create customer user
        $customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@mystar.com',
            'password' => bcrypt('password'),
            'phone' => '+970599000002',
            'address' => 'Gaza, Palestine',
            'city' => 'Gaza',
            'country' => 'Palestine',
            'is_active' => true,
        ]);
        $customer->roles()->attach($customerRole);

        // Create customer address
        Address::create([
            'user_id' => $customer->id,
            'full_name' => 'Customer User',
            'phone' => '+970599000002',
            'address_line_1' => '123 Main Street',
            'address_line_2' => 'Apt 4B',
            'city' => 'Gaza',
            'state' => 'Gaza Strip',
            'country' => 'Palestine',
            'postal_code' => 'P12345',
            'is_default' => true,
        ]);

        // Create categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and accessories',
            'is_active' => true,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'description' => 'Fashion and apparel',
            'is_active' => true,
        ]);

        $home = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'description' => 'Home improvement and garden supplies',
            'is_active' => true,
        ]);

        // Create subcategories
        $phones = Category::create([
            'name' => 'Mobile Phones',
            'slug' => 'mobile-phones',
            'description' => 'Smartphones and mobile accessories',
            'parent_id' => $electronics->id,
            'is_active' => true,
        ]);

        $laptops = Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'description' => 'Laptop computers and accessories',
            'parent_id' => $electronics->id,
            'is_active' => true,
        ]);

        // Create products
        Product::create([
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'description' => 'Latest Apple iPhone with advanced features',
            'price' => 4999.00,
            'compare_price' => 5499.00,
            'sku' => 'IPHONE15PRO',
            'quantity' => 50,
            'min_quantity' => 1,
            'is_active' => true,
            'is_featured' => true,
            'category_id' => $phones->id,
            'merchant_id' => $merchant->id,
        ]);

        Product::create([
            'name' => 'Samsung Galaxy S24',
            'slug' => 'samsung-galaxy-s24',
            'description' => 'Latest Samsung flagship smartphone',
            'price' => 4299.00,
            'compare_price' => 4799.00,
            'sku' => 'SAMSUNGS24',
            'quantity' => 40,
            'min_quantity' => 1,
            'is_active' => true,
            'is_featured' => true,
            'category_id' => $phones->id,
            'merchant_id' => $merchant->id,
        ]);

        Product::create([
            'name' => 'MacBook Pro 14"',
            'slug' => 'macbook-pro-14',
            'description' => 'Apple MacBook Pro with M3 chip',
            'price' => 8999.00,
            'compare_price' => 9999.00,
            'sku' => 'MACBOOKPRO14',
            'quantity' => 20,
            'min_quantity' => 1,
            'is_active' => true,
            'is_featured' => true,
            'category_id' => $laptops->id,
            'merchant_id' => $merchant->id,
        ]);

        // Create coupons
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10.00,
            'min_order_amount' => 100.00,
            'max_discount_amount' => 50.00,
            'usage_limit' => 100,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE50',
            'type' => 'fixed',
            'value' => 50.00,
            'min_order_amount' => 200.00,
            'usage_limit' => 50,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);

        // Create offers
        $flashSale = Offer::create([
            'name' => 'Flash Sale',
            'description' => 'Limited time flash sale on selected items',
            'type' => 'flash_sale',
            'discount_type' => 'percentage',
            'discount_value' => 20.00,
            'start_date' => now(),
            'end_date' => now()->addDays(3),
            'is_active' => true,
        ]);

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
