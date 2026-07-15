<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Smart devices and everyday tech'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Comfortable essentials for every day'],
            ['name' => 'Home & Living', 'slug' => 'home-living', 'description' => 'Practical pieces for your home'],
            ['name' => 'Beauty & Care', 'slug' => 'beauty-care', 'description' => 'Simple self-care essentials'],
        ];

        foreach ($categories as &$category) {
            $existing = $this->db->table('categories')->where('slug', $category['slug'])->get()->getRowArray();
            if ($existing) {
                $category['id'] = $existing['id'];
            } else {
                $category['is_active'] = 1;
                $category['created_at'] = date('Y-m-d H:i:s');
                $category['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('categories')->insert($category);
                $category['id'] = $this->db->insertID();
            }
        }
        unset($category);
        $categoryIds = array_column($categories, 'id', 'slug');

        $products = [
            ['category' => 'electronics', 'name' => 'Wave Bluetooth Headphones', 'slug' => 'wave-bluetooth-headphones', 'sku' => 'ELEC-HP-001', 'description' => 'Over-ear wireless headphones with deep bass and 30-hour battery.', 'price' => 3499, 'sale_price' => 2999, 'stock' => 24, 'image' => 'https://placehold.co/600x400/182848/ffffff?text=Headphones'],
            ['category' => 'electronics', 'name' => 'Glow Smart Desk Lamp', 'slug' => 'glow-smart-desk-lamp', 'sku' => 'ELEC-LP-002', 'description' => 'Adjustable LED desk lamp with three colour temperatures.', 'price' => 1899, 'sale_price' => null, 'stock' => 18, 'image' => 'https://placehold.co/600x400/4b6cb7/ffffff?text=Smart+Lamp'],
            ['category' => 'electronics', 'name' => 'Pocket Power Bank 10000mAh', 'slug' => 'pocket-power-bank-10000mah', 'sku' => 'ELEC-PB-003', 'description' => 'Slim fast-charging USB-C power bank for your daily commute.', 'price' => 1599, 'sale_price' => 1299, 'stock' => 35, 'image' => 'https://placehold.co/600x400/3a506b/ffffff?text=Power+Bank'],
            ['category' => 'fashion', 'name' => 'Classic Cotton T-Shirt', 'slug' => 'classic-cotton-t-shirt', 'sku' => 'FASH-TS-001', 'description' => 'Soft 100% cotton regular-fit t-shirt in everyday colours.', 'price' => 799, 'sale_price' => 599, 'stock' => 50, 'image' => 'https://placehold.co/600x400/6c5ce7/ffffff?text=Cotton+T-Shirt'],
            ['category' => 'fashion', 'name' => 'Urban Canvas Backpack', 'slug' => 'urban-canvas-backpack', 'sku' => 'FASH-BG-002', 'description' => 'Water-resistant backpack with padded laptop sleeve.', 'price' => 2299, 'sale_price' => null, 'stock' => 16, 'image' => 'https://placehold.co/600x400/2d3436/ffffff?text=Backpack'],
            ['category' => 'fashion', 'name' => 'Minimal Steel Watch', 'slug' => 'minimal-steel-watch', 'sku' => 'FASH-WT-003', 'description' => 'Clean analogue watch with a stainless-steel mesh strap.', 'price' => 2799, 'sale_price' => 2399, 'stock' => 12, 'image' => 'https://placehold.co/600x400/636e72/ffffff?text=Steel+Watch'],
            ['category' => 'home-living', 'name' => 'Ceramic Coffee Mug Set', 'slug' => 'ceramic-coffee-mug-set', 'sku' => 'HOME-MG-001', 'description' => 'Set of two speckled ceramic mugs for your morning coffee.', 'price' => 999, 'sale_price' => null, 'stock' => 28, 'image' => 'https://placehold.co/600x400/c8a27a/ffffff?text=Ceramic+Mugs'],
            ['category' => 'home-living', 'name' => 'Scented Soy Candle', 'slug' => 'scented-soy-candle', 'sku' => 'HOME-CD-002', 'description' => 'Hand-poured soy candle with a calm sandalwood fragrance.', 'price' => 649, 'sale_price' => 499, 'stock' => 40, 'image' => 'https://placehold.co/600x400/a77e58/ffffff?text=Soy+Candle'],
            ['category' => 'beauty-care', 'name' => 'Daily Hydration Face Wash', 'slug' => 'daily-hydration-face-wash', 'sku' => 'BEAU-FW-001', 'description' => 'Gentle gel cleanser suitable for normal and dry skin.', 'price' => 449, 'sale_price' => null, 'stock' => 32, 'image' => 'https://placehold.co/600x400/e170b5/ffffff?text=Face+Wash'],
            ['category' => 'beauty-care', 'name' => 'Herbal Body Lotion', 'slug' => 'herbal-body-lotion', 'sku' => 'BEAU-BL-002', 'description' => 'Lightweight moisturiser with aloe vera and shea butter.', 'price' => 549, 'sale_price' => 449, 'stock' => 27, 'image' => 'https://placehold.co/600x400/f8a5c2/ffffff?text=Body+Lotion'],
        ];

        foreach ($products as $product) {
            $categoryId = $categoryIds[$product['category']];
            unset($product['category']);
            $product += ['category_id' => $categoryId, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
            $existing = $this->db->table('products')->where('sku', $product['sku'])->get()->getRowArray();
            if ($existing) {
                $this->db->table('products')->where('id', $existing['id'])->update($product);
            } else {
                $this->db->table('products')->insert($product);
            }
        }
    }
}
