<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Voguepay]].
 *
 * @see Voguepay
 */
class VoguepayQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Voguepay[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Voguepay|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}