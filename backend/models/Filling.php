<?php

namespace app\models;
use yii\db\ActiveRecord;

class Filling extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filling}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [["tank_id", "username", "volume"], "required"],
            [["tank_id", "volume"], "integer"],
            [["username"], "string", "max" => 255],
            [["tank_id"], "exist", "targetClass" => Tank::class, "targetAttribute" => ["tank_id" => "id"], "message" => "Указанной цистерны не существует."],
        ];
    }
}