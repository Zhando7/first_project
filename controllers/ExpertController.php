<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\base\Model;
use yii\data\Pagination;

/**
* Подключаемые модели
*/
use app\models\Login\LoginExp;
use app\models\Signup\SignupExp;
use app\models\Tables\Users;
use app\models\Tables\Partteam;
use app\models\Tables\Userfiles;
use app\models\Tables\Competence;
use app\models\Tables\Criterion;
use app\models\Tables\Crudevalutionpr;
use app\models\Tables\Crudevalutioncom;
use app\models\Tables\Bidpr;
use app\models\Tables\Bidcom;
use app\models\Tables\Evalutionpr;
use app\models\Tables\Evalutioncom;
use app\models\Tables\Resultspr;
use app\models\Tables\Resultscom;
use app\models\Search\SearchExp;
use app\models\Search\SearchBidPrExp;
use app\models\Search\SearchBidComExp;
use app\models\Edit\EditExp;

class ExpertController extends Controller
{
	/** 
	* Функция представления формы для авторизации эксперта
	*/
	public function actionLogin(){
		if(Yii::$app->user->isGuest):
			$url = Url::previous();
			$model = new LoginExp;
			
			if($model->load(Yii::$app->request->post())):
				if($model->login()):
					return $this->goHome();
				endif;
			endif;
			
			return $this->render('login', ['model' => $model, 'url' => $url]);
		endif;
		
		return $this->goHome();
	}
	/** 
	* Функция представления формы для регистратции эксперта
	*/
	public function actionSignup(){
		if(Yii::$app->user->isGuest):
			$url = Url::previous();
			$model = new SignupExp();
			
			if($model->load(Yii::$app->request->post()) and $model->validate()):
				if($user = $model->signup()):
					if(Yii::$app->getUser()->login($user)):
						return $this->goHome();
					endif;
				endif;
			endif;
			
			return $this->render('signup', ['model' => $model, 'url' => $url]);
		endif;
		
		return $this->goHome();
	}
	/**
	* Функция представления страницы экспертный совет
	*/
	public function actionIndexexp(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			Url::remember();
			$searchModel = new SearchExp();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexexp', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// Функция представления формы для редактирования данных эксперта
	public function actionEditexp(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			$url = Url::previous();
			if($model = Users::getExp(Yii::$app->user->identity['IdUser'])):
				$one = new EditExp();
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editexp', ['one' => $one, 'model' => $model, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы оценивания участников
	*/
	public function actionIndexevapr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			Url::remember();
			$searchModel = new SearchBidPrExp();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexevapr', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	/**
	* Функция создания таблицы оценивания для выбранного экспертом оценивания
	*/
	public function actionBeginevapr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			if(Evalutionpr::getMe($id)):																		// Если эксперт уже оценивал не создавать данные для оценивания участников
				return $this->redirect(['/expert/indexinputevapr/'.$id]);
			else:																								// Иначе создать данные для оценивания участников
				if(($competence = Crudevalutionpr::getOne($id)) and ($selectbid = Bidpr::getSelectBid($id))):	// Проверка на существование выбранного оценивания и заявок на это оценивание
					$criterion = Criterion::getCompetence($competence->IdCompetence);
					$iduser = Yii::$app->user->identity['IdUser'];
					
					foreach($selectbid as $partaker):
						foreach($criterion as $item):
							$model = new Evalutionpr();
							$model->IdEvalution = $id;
							$model->IdExp = $iduser;
							$model->IdPartaker = $partaker->IdUser;
							$model->IdCompetence = $competence->IdCompetence;
							$model->IdCriterion = $item->IdCriterion;
							$model->TodayDate = $competence->TodayDate;
							$model->save();
						endforeach;
					endforeach;
					return $this->redirect(['/expert/indexinputevapr/'.$id]);
				endif;
			endif;										// Конец всей условий
			return $this->redirect(Url::previous());	// Выполняется если участников на выбранное оценивание нету
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы для введения оценок по каждому из участников выбранной оцениваний
	*/
	public function actionIndexinputevapr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			Url::remember();
			if(($model = Evalutionpr::getSelectEva($id)) and ($partaker = Evalutionpr::getPartaker($id))):
				
				if(Model::loadMultiple($model, Yii::$app->request->post()) and Model::validateMultiple($model)):
					foreach($model as $item):
						$item->save();
					endforeach;
					// Далее происходит создание результата для каждого участника
					if(($allitems = Evalutionpr::getAll($id)) and ($countpr = Evalutionpr::getCountPr($id))):
						foreach($countpr as $pr):
							foreach($allitems as $items):
								if($pr->IdPartaker == $items->IdPartaker):
									$sum += $items->Evalution;	// В переменную sum инкрементируем результаты участника и на выходе получаем общий результат по компетенций
								endif;
							endforeach;
							$infoeva = Crudevalutionpr::getOne($id);			// Заполняется информацией об оцениваний
							$infopr = Users::getPr($pr->IdPartaker);			// Заполняется информацией об участнике
							$infocp = Competence::getOne($pr->IdCompetence);	// Заполняется информацией об компетенций
							if(!Resultspr::find()->where(['IdEvalution' => $id, 'IdPartaker' => $pr->IdPartaker])->one()):	// Если нет результата участника по данной оцениваний то создаем его
								$res = new Resultspr();
								$res->IdEvalution = $id;
								$res->IdPartaker = $pr->IdPartaker;
								$res->Result = $sum;
								$res->Fio = $infopr->Surname.' '.$infopr->Name.' '.$infopr->Patronymic;
								$res->ClassChild = $infopr->Field1;
								$res->Language = $infopr->Field2;
								$res->District = $infopr->Field3;
								$res->School = $infopr->Field4;
								$res->Competence = $infocp->Name;
								$res->NameEvalution = $infoeva->Name;
								$res->TodayDate = $infoeva->TodayDate;
								$res->save();
							else:	// Иначе если он существует, то обновляем его результат
								Resultspr::updateAll(
									[
										'IdEvalution' => $id, 							/* Присваемые значения */
										'IdPartaker' => $pr->IdPartaker, 
										'Result' => $sum,
										'Fio' => $infopr->Surname.' '.$infopr->Name.' '.$infopr->Patronymic,
										'ClassChild' => $infopr->Field1,
										'Language' => $infopr->Field2,
										'District' => $infopr->Field3,
										'School' => $infopr->Field4,
										'Competence' => $infocp->Name,
										'NameEvalution' => $infoeva->Name,
										'TodayDate' => $infoeva->TodayDate,
									],	
									['IdEvalution' => $id, 'IdPartaker' => $pr->IdPartaker]		// Поиск участника по соответсвующей оцениваний
								);
							endif;
							$sum = 0;	// Обнуляем переменную sum для дальнейшего его заполения
						endforeach;
					endif;
					return $this->redirect(['/expert/indexevapr']);
				endif;
				
				return $this->render('indexinputevapr', ['model' => $model, 'partaker' => $partaker]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы оценивания комманд
	*/
	public function actionIndexevacom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			Url::remember();
			$searchModel = new SearchBidComExp();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexevacom', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	/**
	* Функция создания таблицы оценивания для выбранного экспертом оценивания
	*/
	public function actionBeginevacom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			if(Evalutioncom::getMe($id)):																		// Если эксперт уже оценивал не создавать данные для оценивания участников
				return $this->redirect(['/expert/indexinputevacom/'.$id]);
			else:																								// Иначе создать данные для оценивания участников
				if(($competence = Crudevalutioncom::getOne($id)) and ($selectbid = Bidcom::getSelectBid($id))):	// Проверка на существование выбранного оценивания и заявок на это оценивание
					$criterion = Criterion::getCompetence($competence->IdCompetence);
					$iduser = Yii::$app->user->identity['IdUser'];
					
					foreach($selectbid as $partaker):
						foreach($criterion as $item):
							$model = new Evalutioncom();
							$model->IdEvalution = $id;
							$model->IdExp = $iduser;
							$model->IdCommand = $partaker->IdUser;
							$model->IdCompetence = $competence->IdCompetence;
							$model->IdCriterion = $item->IdCriterion;
							$model->TodayDate = $competence->TodayDate;
							$model->save();
						endforeach;
					endforeach;
					return $this->redirect(['/expert/indexinputevacom/'.$id]);
				endif;
			endif;										// Конец всей условий
			return $this->redirect(Url::previous());	// Выполняется если участников на выбранное оценивание нету
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы для введения оценок по каждому из участников выбранной оцениваний
	*/
	public function actionIndexinputevacom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			Url::remember();
			if(($model = Evalutioncom::getSelectEva($id)) and ($commands = Evalutioncom::getCommands($id))):
				
				if(Model::loadMultiple($model, Yii::$app->request->post()) and Model::validateMultiple($model)):
					foreach($model as $item):
						$item->save();
					endforeach;
					// Далее происходит создание результата для каждой команды
					if(($allitems = Evalutioncom::getAll($id)) and ($countcom = Evalutioncom::getCountCom($id))):
						foreach($countcom as $com):
							foreach($allitems as $items):
								if($com->IdCommand == $items->IdCommand):
									$sum += $items->Evalution;	// В переменную sum инкрементируем результаты команды и на выходе получаем общий результат по компетенций
								endif;
							endforeach;
							$infoeva = Crudevalutioncom::getOne($id);			// Заполняется информацией об оцениваний
							$infocom = Users::getCom($com->IdCommand);			// Заполняется информацией о команде
							$infocp = Competence::getOne($com->IdCompetence);	// Заполняется информацией об компетенций
							if(!Resultscom::find()->where(['IdEvalution' => $id, 'IdCommand' => $com->IdCommand])->one()):	// Если нет результата команды по данной оцениваний то создаем его
								$res = new Resultscom();
								$res->IdEvalution = $id;
								$res->IdCommand = $com->IdCommand;
								$res->Result = $sum;
								$res->NameCommand = $infocom->Name;
								$res->Competence = $infocp->Name;
								$res->NameEvalution = $infoeva->Name;
								$res->TodayDate = $infoeva->TodayDate;
								$res->save();
							else:	// Иначе если он существует, то обновляем его результат
								Resultscom::updateAll(
									[
										'IdEvalution' => $id, 						/* Присваемые значения */
										'IdCommand' => $com->IdCommand, 
										'Result' => $sum,
										'NameCommand' => $infocom->Name,
										'Competence' => $infocp->Name,
										'NameEvalution' => $infoeva->Name,
										'TodayDate' => $infoeva->TodayDate,
									],	
									['IdEvalution' => $id, 'IdCommand' => $com->IdCommand]		// Поиск команды по соответсвующей оцениваний
								);
							endif;
							$sum = 0;	// Обнуляем переменную sum для дальнейшего его заполения
						endforeach;
					endif;
					return $this->redirect(['/expert/indexevacom']);
				endif;
				
				return $this->render('indexinputevacom', ['model' => $model, 'commands' => $commands]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы "Данные команды"
	*/
	public function actionInfocom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			if(($namecommand = Users::getCom($id)) and ($child = Partteam::getChilds($id))):
				$files = Userfiles::getFilesUser($id);
				return $this->render('infocom', ['namecommand' => $namecommand, 'child' => $child, 'files' => $files]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы "Данные участника"
	*/
	public function actionInfopr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			if($model = Users::getPr($id)):
				$files = Userfiles::getFilesUser($id);
				return $this->render('infopr', ['model' => $model, 'files' => $files]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* Функция скачивания загруженных работ участников или команд
	*/
	public function actionDownload($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 2)):
			$url = Url::previous();
			if($one = Userfiles::getFile($id)):
				return Yii::$app->response->sendFile('uploadedfiles/'.$one->NameFile);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
}
?>