<?php

use yii\db\Schema;
use yii\db\Migration;

class m151128_155001_init_create_price_table extends Migration
{
    public function up()
    {
		$this->createTable(
			"price", 
			[
				'id' => $this->primaryKey(),
				'min_price' => 'integer NOT NULL',
				'max_price' => 'integer NOT NULL',
				'price' => 'double NOT NULL',								
				'updated_at' => $this->timestamp()->notNull(),
			]
		);
    }

    public function down()
    {
        $this->dropTable('price');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
