<?php

namespace console\controllers;

use Exception;
use modules\api\models\Coverage;
use modules\api\models\Pokemon;
use modules\api\models\Type;
use Yii;
use yii\console\Controller;

class InitController extends Controller
{
    public function actionPokemon()
    {
        try {
            $imgUrl = Yii::getAlias('@webapp/assets/webpack/src/img/pokemon/');
            $path = Yii::getAlias('@data/pokemondb.json');
            $datasJson = file_get_contents($path);
            $datas = json_decode($datasJson);
            foreach ($datas as $data) {
                $pokemon = Pokemon::findOne(['name' => $data->name, 'form' => $data->form]);
                if ($pokemon == null) {
                    $pokemon = Yii::createObject(Pokemon::class);
                }
                $pokemon->number = $data->number;
                $pokemon->name = $data->name;
                $pokemon->form = $data->form;
                $types = $data->type;

                foreach ($types as $key => $typeValue) {
                    $type = Type::findOne(['name' => $typeValue]);
                    if ($type == null) {
                        $type = Yii::createObject(Type::class);
                        $type->name = $typeValue;
                        $type->save();
                    }

                    if ($key == 0) {
                        $pokemon->type1Id = $type->id;
                    }

                    if ($key == 1) {
                        $pokemon->type2Id = $type->id;
                    }
                }
                $filename = basename($data->artWork);
                $complete_save_loc = $imgUrl . $filename;
                file_put_contents($complete_save_loc, file_get_contents($data->artWork));
                $pokemon->image = $filename;
                $pokemon->total = $data->total;
                $pokemon->hp = $data->total;
                $pokemon->attack = $data->attack;
                $pokemon->defense = $data->defense;
                $pokemon->spAtk = $data->spAtk;
                $pokemon->spDef = $data->spDef;
                $pokemon->speed = $data->speed;
                if ($pokemon->save() === true) {
                    $consoleMessage = '#'.$pokemon->number.' - '.$pokemon->name;
                    if ($pokemon->form != null) {
                        $consoleMessage = $consoleMessage.' ('.$pokemon->form.')';
                    }
                    echo($consoleMessage."\n");
                }
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    public function actionPokemonFr()
    {
        try {
            $path = Yii::getAlias('@data/fr.json');
            $datasJson = file_get_contents($path);
            $datas = json_decode($datasJson);
            foreach ($datas as $data) {
                $pokemons = Pokemon::findAll(['number' => $data->number]);
                foreach ($pokemons as $pokemon) {
                    $pokemon->nameFr = $data->name;
                    $pokemon->save();
                }
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    public function actionGeneration()
    {
        try {
            $pokemons = Pokemon::find()->orderBy('id')->all();
            foreach ($pokemons as $pokemon) {
                $number = intval($pokemon->number);
                if ($number >= 1 && $number <= 151) {
                    $pokemon->generation = 1;
                } else if ($number <= 251) {
                    $pokemon->generation = 2;
                } else if ($number <= 386) {
                    $pokemon->generation = 3;
                } else if ($number <= 494) {
                    $pokemon->generation = 4;
                } else if ($number <= 649) {
                    $pokemon->generation = 5;
                } else if ($number <= 721) {
                    $pokemon->generation = 6;
                } else if ($number <= 809) {
                    $pokemon->generation = 7;
                } else if ($number <= 905) {
                    $pokemon->generation = 8;
                } else {
                    $pokemon->generation = 9;
                }
                $pokemon->save();
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    public function actionType()
    {
        try {
            /** @var Type[] $types */
            $types = Type::find()->all();
            foreach ($types as $type) {
                switch ($type->name) {
                    case 'steel':
                        $this->createCoverage($type,'fighting', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fire', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ground', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'steel', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'dragon', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'fairy', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'ice', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'bug', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'normal', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'grass', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'psychic', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'rock', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'flying', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'poison', Coverage::STATUS_IMMUNE);
                        break;
                    case 'fighting':
                        $this->createCoverage($type,'fairy', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'psychic', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'flying', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'bug', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'rock', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'dark', Coverage::STATUS_RESIST);
                        break;
                    case 'grass':
                        $this->createCoverage($type,'fire', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ice', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'bug', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'poison', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'flying', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'grass', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'water', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'ground', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'electric', Coverage::STATUS_RESIST);
                        break;
                    case 'poison':
                        $this->createCoverage($type,'psychic', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ground', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'fairy', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'bug', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'grass', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'poison', Coverage::STATUS_RESIST);
                        break;
                    case 'dragon':
                        $this->createCoverage($type,'dragon', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fairy', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ice', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'water', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'electric', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'fire', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'grass', Coverage::STATUS_RESIST);
                        break;
                    case 'water':
                        $this->createCoverage($type,'electric', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'grass', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'steel', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'water', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'fire', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'ice', Coverage::STATUS_RESIST);
                        break;
                    case 'electric':
                        $this->createCoverage($type,'ground', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'steel', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'electric', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'flying', Coverage::STATUS_RESIST);
                        break;
                    case 'fairy':
                        $this->createCoverage($type,'steel', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'poison', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'bug', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'dark', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'dragon', Coverage::STATUS_IMMUNE);
                        break;
                    case 'fire':
                        $this->createCoverage($type,'water', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'rock', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ground', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'steel', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'fairy', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'fire', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'ice', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'bug', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'grass', Coverage::STATUS_RESIST);
                        break;
                    case 'ice':
                        $this->createCoverage($type,'steel', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fire', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'rock', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ice', Coverage::STATUS_RESIST);
                        break;
                    case 'bug':
                        $this->createCoverage($type,'fire', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'flying', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'rock', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'grass', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'ground', Coverage::STATUS_RESIST);
                        break;
                    case 'normal':
                        $this->createCoverage($type,'fighting', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ghost', Coverage::STATUS_IMMUNE);
                        break;
                    case 'psychic':
                        $this->createCoverage($type,'bug', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ghost', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'dark', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'psychic', Coverage::STATUS_RESIST);
                        break;
                    case 'rock':
                        $this->createCoverage($type,'steel', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'water', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'grass', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ground', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fire', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'normal', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'poison', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'flying', Coverage::STATUS_RESIST);
                        break;
                    case 'ground':
                        $this->createCoverage($type,'water', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ice', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'grass', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'rock', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'poison', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'electric', Coverage::STATUS_IMMUNE);
                        break;
                    case 'ghost':
                        $this->createCoverage($type,'ghost', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'dark', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'bug', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'poison', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_IMMUNE);
                        $this->createCoverage($type,'normal', Coverage::STATUS_IMMUNE);
                        break;
                    case 'dark':
                        $this->createCoverage($type,'fighting', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fairy', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'bug', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ghost', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'dark', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'psychic', Coverage::STATUS_IMMUNE);
                        break;
                    case 'flying':
                        $this->createCoverage($type,'electric', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'ice', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'rock', Coverage::STATUS_WEAK);
                        $this->createCoverage($type,'fighting', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'bug', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'grass', Coverage::STATUS_RESIST);
                        $this->createCoverage($type,'ground', Coverage::STATUS_IMMUNE);
                        break;
                }
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }

    private function createCoverage($mainType, $targetTypeName, $status) {
        $targetType = Type::findOne(['name' => $targetTypeName]);
        if ($targetType !== null) {
            $coverage = Yii::createObject(Coverage::class);
            $coverage->mainTypeId = $mainType->id;
            $coverage->targetTypeId = $targetType->id;
            $coverage->status = $status;
            $coverage->save();
        }
    }
}