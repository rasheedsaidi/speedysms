<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "voguepay".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $transaction_id
 * @property string $email
 * @property double $total
 * @property string $merchant_ref
 * @property string $memo
 * @property string $status
 * @property string $date
 * @property string $referrer
 * @property string $method
 */
class Voguepay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'voguepay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'transaction_id'], 'required'],
            [['user_id'], 'integer'],
            [['total'], 'number'],
            [['memo'], 'string'],
            [['date', 'posted_at'], 'safe'],
            [['transaction_id', 'merchant_ref'], 'string', 'max' => 100],
            [['email', 'referrer'], 'string', 'max' => 255],
            [['status', 'method'], 'string', 'max' => 50]
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
            'transaction_id' => 'Transaction ID',
            'email' => 'Email',
            'total' => 'Total',
            'merchant_ref' => 'Merchant Ref',
            'memo' => 'Memo',
            'status' => 'Status',
            'date' => 'Date',
            'referrer' => 'Referrer',
            'method' => 'Method',
        ];
    }

    /**
     * @inheritdoc
     * @return VoguepayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VoguepayQuery(get_called_class());
    }
}
