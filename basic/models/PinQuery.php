<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Pin]].
 *
 * @see Pin
 */
class PinQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Pin[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pin|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}