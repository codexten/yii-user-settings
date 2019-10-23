<?php

namespace codexten\yii\user\settings\models\query;

/**
 * This is the ActiveQuery class for [[\codextend\yii\user\settings\models\UserSetting]].
 *
 * @see \codextend\yii\user\settings\models\UserSetting
 */
class UserSettingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \codextend\yii\user\settings\models\UserSetting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \codextend\yii\user\settings\models\UserSetting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
