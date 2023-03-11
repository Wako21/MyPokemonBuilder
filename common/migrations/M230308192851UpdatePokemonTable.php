<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class M230304181430CreateCoverageTable
 */
class M230308192851UpdatePokemonTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%pokemons}}', 'nameFr', $this->string().' after name');
        $this->addColumn('{{%pokemons}}', 'generation', $this->string().' after nameFr');
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%pokemons}}', 'generation');
        $this->dropColumn('{{%pokemons}}', 'nameFr');
        return true;
    }
}
