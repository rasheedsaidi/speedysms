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
    	//'css/udacity1.css',
    	'css/normalize.css',
    	//'css/component.css',
    	'css/styles_sidemenu.css',
    	'blueimp-file-upload/css/jquery.fileupload.css',
    	'css/sms.css',
    	'css/jquery.datetimepicker.css',
    	'web/assets2/plugins/font-awesome/css/font-awesome.css',
    	'web/assets2/css/style1.css',
    	'web/assets2/css/style1.css',
    	'web/assets2/plugins/owl-carousel/owl.carousel.css',
    	'web/assets/plugins/owl-carousel/owl.theme.css',
    ];
    public $js = [
    	'web/js/modernizr.custom.js',
    	//'js/jquery-1.11.0.min.js',
    	'web/js/bootstrap.min.js',    	
    	'web/blueimp-file-upload/js/vendor/jquery.ui.widget.js',
    	'web/blueimp-file-upload/js/jquery.iframe-transport.js',
    	'web/blueimp-file-upload/js/jquery.fileupload.js',
    	'web/js/message.js',
    	'web/js/jquery.datetimepicker.full.min.js',
    	'web/js/script_sidemenu.js',
    	'web/assets2/plugins/owl-carousel/owl.carousel.js',
    	'web/assets2/plugins/counter/jquery.countTo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
