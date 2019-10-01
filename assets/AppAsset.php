<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
		'css/required.css',
		'css/font-awesome.css'
    ];
    public $js = [
		'js/fusioncharts.js',
		'js/fusioncharts.charts.js',
		'js/themes/fusioncharts.theme.fint.js'
    ];
	public $jsOptions = [
		'position' => \yii\web\View::POS_HEAD
	];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
