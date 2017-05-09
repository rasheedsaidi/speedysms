<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Course]].
 *
 * @see Course
 */
class CoursesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Course[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Course|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}