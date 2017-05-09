<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SentMessage]].
 *
 * @see SentMessage
 */
class SentMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return SentMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SentMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}