<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class BulkFile extends Model
{
    /**
     * @var UploadedFile
     */
    public $numbersFile;

    public function rules()
    {
        return [
            [['numbersFile'], 'file', 'skipOnEmpty' => false, 'checkExtensionByMimeType' => false, 'extensions' => 'xls, csv, txt, xlsx'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
        	$n = 'bulk_file_' . substr(md5(mktime()), 1, 10) . '.' . $this->numbersFile->extension;
            //$this->numbersFile->saveAs(Yii::$app->basePath . '/web/uploads/' . $n);
            $this->numbersFile->saveAs(Utility::getBasePath() . '/uploads/' . $n);
            $this->numbersFile->name = $n;
            return true;
        } else {
            return false;
        }
    }
}