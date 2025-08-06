<?php

namespace app\models;
use yii\db\ActiveRecord;

class Tank extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    const MAX_VOLUME = 300;
    public static function tableName()
    {
        return '{{%tank}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['current_volume'], 'required'],
            [['current_volume'], 'integer', 'min' => 0, 'max' => self::MAX_VOLUME],
        ];
    }
}