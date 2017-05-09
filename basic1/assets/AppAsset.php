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
    	'css/udacity.css',
    	'css/normalize.css',
    	'css/component.css',
    	'css/styles_sidemenu.css',
    	'blueimp-file-upload/css/jquery.fileupload.css',
    ];
    public $js = [
    	'js/modernizr.custom.js',
    	//'js/jquery-1.11.0.min.js',
    	'js/bootstrap.min.js',    	
    	'blueimp-file-upload/js/vendor/jquery.ui.widget.js',
    	'blueimp-file-upload/js/jquery.iframe-transport.js',
    	'blueimp-file-upload/js/jquery.fileupload.js',
    	'js/message.js',
    	'js/script_sidemenu.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
