<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "price".
 *
 * @property integer $id
 * @property integer $min_price
 * @property integer $max_price
 * @property double $price
 * @property string $updated_at
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['min_price', 'max_price', 'price', 'type'], 'required'],
            [['min_price', 'max_price'], 'integer'],
            [['price'], 'number'],
            [['updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'min_price' => 'Min Price',
            'max_price' => 'Max Price',
            'price' => 'Price',
        	'type' => 'Type',
            'updated_at' => 'Updated At',
        ];
    }
}
