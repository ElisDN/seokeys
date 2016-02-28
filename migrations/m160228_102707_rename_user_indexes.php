<?php

use yii\db\Migration;

class m160228_102707_rename_user_indexes extends Migration
{
    public function up()
    {
        $this->dropIndex('idx_user_username', '{{%user}}');
        $this->dropIndex('idx_user_email', '{{%user}}');
        $this->dropIndex('idx_user_status', '{{%user}}');

        $this->createIndex('idx-user-username', '{{%user}}', 'username');
        $this->createIndex('idx-user-email', '{{%user}}', 'email');
        $this->createIndex('idx-user-status', '{{%user}}', 'status');
    }

    public function down()
    {
        $this->dropIndex('idx-user-username', '{{%user}}');
        $this->dropIndex('idx-user-email', '{{%user}}');
        $this->dropIndex('idx-user-status', '{{%user}}');

        $this->createIndex('idx_user_username', '{{%user}}', 'username');
        $this->createIndex('idx_user_email', '{{%user}}', 'email');
        $this->createIndex('idx_user_status', '{{%user}}', 'status');
    }
}
