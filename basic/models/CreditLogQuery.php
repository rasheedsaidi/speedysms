<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[CreditLog]].
 *
 * @see CreditLog
 */
class CreditLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CreditLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CreditLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}