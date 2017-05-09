<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pin".
 *
 * @property integer $id
 * @property integer $amount
 * @property string $pin
 * @property string $status
 * @property string $createdate
 * @property string $transid
 * @property string $dateused
 */
class Pin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'pin', 'status'], 'required'],
            [['amount'], 'integer'],
            [['status'], 'string'],
            [['createdate', 'dateused', 'serialno'], 'safe'],
            [['pin'], 'string', 'max' => 255],
            [['transid'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'pin' => 'Pin',
        	'serialno' => 'Serial No',
            'status' => 'Status',
            'createdate' => 'Createdate',
            'transid' => 'Transid',
            'dateused' => 'Dateused',
        ];
    }

    /**
     * @inheritdoc
     * @return PinQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PinQuery(get_called_class());
    }
}
