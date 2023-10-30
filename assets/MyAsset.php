<?php

	namespace app\assets;

	use yii\web\AssetBundle;

	class MyAsset extends AssetBundle {
		public $basePath = '@webroot';
		public $baseUrl = '@web';
		public $js = [
			 'assets/js/functions.js'
		];
	}
