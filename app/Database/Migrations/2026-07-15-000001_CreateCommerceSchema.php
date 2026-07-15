<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommerceSchema extends Migration
{
    public function up()
    {
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'name'=>['type'=>'VARCHAR','constraint'=>120], 'email'=>['type'=>'VARCHAR','constraint'=>160], 'password_hash'=>['type'=>'VARCHAR','constraint'=>255], 'role'=>['type'=>'VARCHAR','constraint'=>20,'default'=>'customer'], 'created_at'=>['type'=>'DATETIME','null'=>true], 'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addUniqueKey('email'); $this->forge->createTable('users');
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'name'=>['type'=>'VARCHAR','constraint'=>100], 'slug'=>['type'=>'VARCHAR','constraint'=>120], 'description'=>['type'=>'TEXT','null'=>true], 'is_active'=>['type'=>'TINYINT','constraint'=>1,'default'=>1], 'created_at'=>['type'=>'DATETIME','null'=>true], 'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addUniqueKey('slug'); $this->forge->createTable('categories');
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'category_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true], 'name'=>['type'=>'VARCHAR','constraint'=>180], 'slug'=>['type'=>'VARCHAR','constraint'=>200], 'sku'=>['type'=>'VARCHAR','constraint'=>80], 'description'=>['type'=>'TEXT','null'=>true], 'price'=>['type'=>'DECIMAL','constraint'=>'12,2'], 'sale_price'=>['type'=>'DECIMAL','constraint'=>'12,2','null'=>true], 'stock'=>['type'=>'INT','constraint'=>11,'default'=>0], 'image'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true], 'is_active'=>['type'=>'TINYINT','constraint'=>1,'default'=>1], 'created_at'=>['type'=>'DATETIME','null'=>true], 'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addUniqueKey('slug'); $this->forge->addUniqueKey('sku'); $this->forge->addForeignKey('category_id','categories','id','CASCADE','CASCADE'); $this->forge->createTable('products');
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'user_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true], 'session_key'=>['type'=>'VARCHAR','constraint'=>100,'null'=>true], 'status'=>['type'=>'VARCHAR','constraint'=>20,'default'=>'active'], 'created_at'=>['type'=>'DATETIME','null'=>true], 'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addKey('user_id'); $this->forge->createTable('carts');
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'cart_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true], 'product_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true], 'quantity'=>['type'=>'INT','constraint'=>11], 'created_at'=>['type'=>'DATETIME','null'=>true], 'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addUniqueKey(['cart_id','product_id']); $this->forge->addForeignKey('cart_id','carts','id','CASCADE','CASCADE'); $this->forge->addForeignKey('product_id','products','id','RESTRICT','CASCADE'); $this->forge->createTable('cart_items');
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'user_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true], 'order_number'=>['type'=>'VARCHAR','constraint'=>40], 'customer_name'=>['type'=>'VARCHAR','constraint'=>130], 'email'=>['type'=>'VARCHAR','constraint'=>160], 'phone'=>['type'=>'VARCHAR','constraint'=>30], 'address'=>['type'=>'TEXT'], 'total'=>['type'=>'DECIMAL','constraint'=>'12,2'], 'status'=>['type'=>'VARCHAR','constraint'=>30,'default'=>'pending'], 'payment_method'=>['type'=>'VARCHAR','constraint'=>40,'default'=>'cod'], 'created_at'=>['type'=>'DATETIME','null'=>true], 'updated_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addUniqueKey('order_number'); $this->forge->createTable('orders');
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'order_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true], 'product_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true], 'product_name'=>['type'=>'VARCHAR','constraint'=>180], 'price'=>['type'=>'DECIMAL','constraint'=>'12,2'], 'quantity'=>['type'=>'INT','constraint'=>11], 'created_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addForeignKey('order_id','orders','id','CASCADE','CASCADE'); $this->forge->createTable('order_items');
        $this->forge->addField(['id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true], 'user_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true], 'token'=>['type'=>'VARCHAR','constraint'=>128], 'expires_at'=>['type'=>'DATETIME','null'=>true], 'created_at'=>['type'=>'DATETIME','null'=>true]]);
        $this->forge->addKey('id', true); $this->forge->addUniqueKey('token'); $this->forge->createTable('api_tokens');
    }
    public function down() { foreach (['api_tokens','order_items','orders','cart_items','carts','products','categories','users'] as $table) $this->forge->dropTable($table, true); }
}
