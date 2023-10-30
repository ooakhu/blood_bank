<?php

    namespace app\widgets;

    use yii\base\Widget;
    use yii\helpers\Html;

    class BoxWidget extends Widget
    {

        public string $width = '100px'; // Default width
        public string $height = '100px'; // Default height

        public function init()
        {
            parent::init();
            echo Html::beginTag('div', ['style' => "width:
			{$this->width}; height: {$this->height}; background-color: #ADD8E6; border: 1px solid blue;", 'class' => 'box']);
        }

        public function run()
        {
            echo Html::endTag('div');
        }
    }

?>
