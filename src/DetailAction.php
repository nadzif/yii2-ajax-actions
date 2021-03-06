<?php

namespace nadzif\actions;

use yii\db\ActiveRecord;
use yii\widgets\DetailView;

class DetailAction extends \yii\base\Action
{
    const METHOD_POST = 'post';
    const METHOD_GET  = 'get';

    public $key    = 'id';
    public $index  = 'expandRowKey';
    public $attributes;
    public $method = self::METHOD_POST;

    /**
     * @var \yii\db\ActiveRecord
     */
    public $modelClass;

    public function run()
    {
        if ($this->method == self::METHOD_POST) {
            $keyIdentifier = \Yii::$app->request->post($this->index);
        } else {
            $keyIdentifier = \Yii::$app->request->get($this->index);
        }

        /** @var ActiveRecord $activeRecord */
        $activeRecord = new $this->modelClass;
        $model        = $activeRecord->findOne([$this->key => $keyIdentifier]);

        return DetailView::widget([
            'id'         => $model->tableSchema->name . '-' . $model->id,
            'options'    => ['class' => 'table detail-view'],
            'model'      => $model,
            'attributes' => $this->attributes,
        ]);

    }
}