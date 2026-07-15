<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class AddManagementFeatures extends Migration {
 public function up(){
  $this->forge->addColumn('users',['is_blocked'=>['type'=>'TINYINT','constraint'=>1,'default'=>0],'profile_image'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],'deleted_at'=>['type'=>'DATETIME','null'=>true]]);
  $this->forge->addColumn('categories',['deleted_at'=>['type'=>'DATETIME','null'=>true]]);$this->forge->addColumn('products',['deleted_at'=>['type'=>'DATETIME','null'=>true]]);
  $this->forge->addField(['id'=>['type'=>'BIGINT','unsigned'=>true,'auto_increment'=>true],'user_id'=>['type'=>'INT','unsigned'=>true,'null'=>true],'event'=>['type'=>'VARCHAR','constraint'=>100],'description'=>['type'=>'VARCHAR','constraint'=>255],'ip_address'=>['type'=>'VARCHAR','constraint'=>45,'null'=>true],'created_at'=>['type'=>'DATETIME']]);$this->forge->addKey('id',true);$this->forge->addKey('user_id');$this->forge->createTable('activity_logs');
  $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'user_id'=>['type'=>'INT','unsigned'=>true],'token'=>['type'=>'VARCHAR','constraint'=>128],'expires_at'=>['type'=>'DATETIME'],'created_at'=>['type'=>'DATETIME']]);$this->forge->addKey('id',true);$this->forge->addUniqueKey('token');$this->forge->createTable('password_resets');
 }
 public function down(){$this->forge->dropTable('password_resets',true);$this->forge->dropTable('activity_logs',true);$this->forge->dropColumn('users',['is_blocked','profile_image','deleted_at']);$this->forge->dropColumn('categories','deleted_at');$this->forge->dropColumn('products','deleted_at');}
}
