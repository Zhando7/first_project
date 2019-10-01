<?php
namespace app\models\Files;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

use app\models\Tables\Userfiles;

class Loadingfiles extends Model
{
	public $files;
	
	public function rules(){
		return [
			[['files'], 'file', 'skipOnEmpty' => false, 'extensions' => ['rar', 'png', 'jpg', 'docx', 'pptx', 'xlsx', 'zip', 'pdf'], 'maxFiles' => 3, 'checkExtensionByMimeType' => false]
		];
	}
	public function upload(){
		if($this->validate()):
			if(Yii::$app->user->identity['AuthKey'] == 1):
				foreach($this->files as $file):
					$file->saveAs('uploadedfiles/' . $file->baseName . '' . Yii::$app->request->get('id') . '.' . $file->extension);
					$model = new Userfiles();
					$model->IdUser = Yii::$app->request->get('id');
					$model->NameFile = $file->baseName . '' . Yii::$app->request->get('id') . '.' . $file->extension;
					$model->TodayDate = date('Y-m-d');
					$model->save();
				endforeach;
			else:
				foreach($this->files as $file):
					$file->saveAs('uploadedfiles/' . $file->baseName . '' . Yii::$app->user->identity['IdUser'] . '.' . $file->extension);
					$model = new Userfiles();
					$model->IdUser = Yii::$app->user->identity['IdUser'];
					$model->NameFile = $file->baseName . '' . Yii::$app->user->identity['IdUser'] . '.' . $file->extension;
					$model->TodayDate = date('Y-m-d');
					$model->save();
				endforeach;
			endif;
			return true;
		else:
			return false;
		endif;
	}
}