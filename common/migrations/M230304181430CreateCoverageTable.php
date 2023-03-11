<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class M230304181430CreateCoverageTable
 */
class M230304181430CreateCoverageTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coverages}}', [
            'id' => $this->bigPrimaryKey(),
            'mainTypeId' => $this->bigInteger(),
            'targetTypeId' => $this->bigInteger(),
            'status' => $this->string()
        ]);
        $this->addForeignKey('pokemon_mainTypeId_fk', '{{%coverages}}', 'mainTypeId', '{{%types}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('pokemon_targetType_fk', '{{%coverages}}', 'targetTypeId', '{{%types}}', 'id', 'CASCADE', 'CASCADE');
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%coverages}}');
        return true;
    }
}
