<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class M221229220038Init
 */
class M221229220038Init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%types}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('{{%pokemons}}', [
            'id' => $this->bigPrimaryKey(),
            'number' => $this->string(),
            'name' => $this->string(),
            'form' => $this->string(),
            'type1Id' => $this->bigInteger(),
            'type2Id' => $this->bigInteger(),
            'image' => $this->string(),
            'total' => $this->integer(),
            'hp' => $this->integer(),
            'attack' => $this->integer(),
            'defense' => $this->integer(),
            'spAtk' => $this->integer(),
            'spDef' => $this->integer(),
            'speed' => $this->integer(),
        ]);
        $this->addForeignKey('pokemon_type1_fk', '{{%pokemons}}', 'type1Id', '{{%types}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('pokemon_type2_fk', '{{%pokemons}}', 'type2Id', '{{%types}}', 'id', 'CASCADE', 'CASCADE');
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pokemons}}');
        $this->dropTable('{{%types}}');
        return true;
    }
}
