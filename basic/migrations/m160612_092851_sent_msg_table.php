<?php

use yii\db\Schema;
use yii\db\Migration;

class m160612_092851_sent_msg_table extends Migration
{
    public function up()
    {
		$this->createTable(
			"sent_message", 
			[
				'id' => $this->primaryKey(),
				'user_id' => $this->integer(),
				'title' => $this->string(),
				'body' => $this->text(),
				'posted_at' => $this->datetime(),						
				'updated_at' => $this->timestamp()->notNull(),
			]
		);
    }

    public function down()
    {
        $this->dropTable("sent_message");
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
