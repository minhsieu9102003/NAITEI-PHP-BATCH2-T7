<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Country;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartItem;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserReview;
use App\Models\ViewedProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding Countries
        Country::factory()->count(10)->create();

        // Seeding Users
        User::factory()->count(10)->create();

        // Create parent categories
        $parentCategories = ProductCategory::factory()->count(5)->create();

        // Create child categories for each parent category
        foreach ($parentCategories as $parentCategory) {
            ProductCategory::factory()
                ->count(3)
                ->withParent($parentCategory)
                ->create();
        }

        // Seeding Products
        Product::factory()->count(50)->create();

        // Seeding Order Statuses
        OrderStatus::factory()->create(['status' => 'pending']);
        OrderStatus::factory()->create(['status' => 'processing']);
        OrderStatus::factory()->create(['status' => 'delivered']);
        OrderStatus::factory()->create(['status' => 'cancelled']);
        OrderStatus::factory()->create(['status' => 'shipped']);

        // Seeding Addresses
        Address::factory()->count(20)->create();

        // Seeding User Addresses
        UserAddress::factory()->count(20)->create();

        // Seeding Shopping Cart
        ShoppingCart::factory()->count(10)->create();

        // Seeding Shopping Cart Items
        ShoppingCartItem::factory()->count(50)->create();

        // Seeding Viewed Products
        ViewedProduct::factory()->count(30)->create();

        // Seeding Order Details
        OrderDetail::factory()->count(20)->create();

        // Seeding Order Items
        OrderItem::factory()->count(50)->create();

        // Seeding User Reviews
        UserReview::factory()->count(30)->create();
    }
}
