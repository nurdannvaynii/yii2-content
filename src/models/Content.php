<?php

namespace nurdannvaynii\content\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $body
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Content extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'body'],'required']
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
