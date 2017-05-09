<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $reference
 * @property string $date
 * @property double $amount
 * @property string $response
 * @property string $description
 * @property string $status
 * @property string $posted_at
 * @property string $updated_at
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['amount'], 'number'],
            [['posted_at', 'updated_at', 'email'], 'safe'],
            [['reference', 'date', 'response', 'description', 'status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'reference' => 'Reference',
            'date' => 'Date',
            'amount' => 'Amount',
            'response' => 'Response',
            'description' => 'Description',
            'status' => 'Status',
        	'email' => 'Email',
            'posted_at' => 'Posted At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return TransactionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TransactionQuery(get_called_class());
    }
}
