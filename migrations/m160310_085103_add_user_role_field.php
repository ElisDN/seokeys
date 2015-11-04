<?php

use yii\db\Migration;

class m160310_085103_add_user_role_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'role', $this->string(64));

        $this->update('{{%user}}', ['role' => 'user']);
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'role');
    }
}
