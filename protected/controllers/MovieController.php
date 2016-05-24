<?php

class MovieController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * Specifies the access control rules.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Movies list
	 */
	public function actionIndex()
	{
		$maxPagesNum = 1000; // API limitation
		$itemsPerPage = 20; // API default number
		$defaultCriteria = ['sort_by' => 'popularity.desc'];
		$page = (int)Yii::app()->request->getParam('page', 1);
		$page = ($page > $maxPagesNum) ? $maxPagesNum : $page;

		$criteria = Yii::app()->request->getParam('criteria', $defaultCriteria);
		$criteria['language'] = Yii::app()->language;
		$criteria['page'] = $page;

		$filter = new MovieFilter();
		$filter->load($criteria);

		$this->render('index', array(
			'filter' => $filter,
			'maxPagesNum' => $maxPagesNum,
			'itemsPerPage' => $itemsPerPage,
			'releaseDateStart' => date('Y-m-d', strtotime("-2 month")),
			'releaseDateEnd' => date('Y-m-d'),
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id
	 */
	public function actionView($id)
	{
		$this->layout = '//layouts/column2';

		$rating = null;
		$model = $this->loadModelByMovieId($id, true);

		// looking whether the movie was rated
		$client = new \TmApi\Client(Yii::app()->user->identity->apiKey);
		$account = new \TmApi\Rest\GuestAccount($client);
		$data = $account->getRatedMovies(Yii::app()->user->identity->guestSessionId);

		if($data && is_array($data->results)) {
			foreach($data->results as $item) {
				if($item->id == $id) {
					$rating = $item->rating;
					break;
				}
			}
		}

		$this->render('view', array(
			'model' => $model,
			'rating' => $rating,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->layout = '//layouts/column2';
		$model=$this->loadModelByMovieId($id);

		if(isset($_POST['Movies']))
		{
			$model->attributes=$_POST['Movies'];
			$model->poster_image = CUploadedFile::getInstance($model, 'poster_image');
			if($model->save()) {
				if($model->poster_image instanceof CUploadedFile) {
					$model->poster_image->saveAs($model->getPosterFullPath());
				}
				$this->redirect(array('view', 'id'=>$model->movie_id));
			}
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModelByMovieId($id);

		// unlink poster image file
		if($model->poster_path) {
			$posterPath = $model->getPosterFullPath();
			if(file_exists($posterPath)) {
				unlink($posterPath);
			}
		}

		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}

	/**
	 * Rates particular movie
	 * @param integer $id
	 * @param integer $rating
	 */
	public function actionRate($id, $rating)
	{
		$client = new \TmApi\Client(Yii::app()->user->identity->apiKey);
		$movies = new \TmApi\Rest\Movies($client);
		$data = $movies->rate($id, $rating, [
			'guest_session_id' => Yii::app()->user->identity->guestSessionId,
		]);

		echo json_encode(array(
			// 1 - rate set, 12 - rate updated
			'status' => ($data && in_array($data->status_code, [1, 12])) ? 1 : 0,
		));
	}

	/**
	 * Remove rating of particular movie
	 * @param integer $id
	 */
	public function actionUnrate($id)
	{
		$client = new \TmApi\Client(Yii::app()->user->identity->apiKey);
		$movies = new \TmApi\Rest\Movies($client);
		$data = $movies->unrate($id, [
			'guest_session_id' => Yii::app()->user->identity->guestSessionId,
		]);

		echo json_encode(array(
			// 13 - rate deleted
			'status' => ($data && in_array($data->status_code, [13])) ? 1 : 0,
		));
	}

	/**
	 * Returns the data model based on the movie ID.
	 * @param integer $id the ID of the movie
	 * @param boolean $create Whether to create new model based on API result
	 * @return Movies the loaded model
	 * @throws Exception
	 */
	public function loadModelByMovieId($id, $create = false)
	{
		$model = Movies::model()->findByAttributes(['movie_id' => $id]);

		if($model === null) {
			if($create === false) {
				throw new CHttpException(404, 'Requested movie not found');
			}

			// create new model based on API result
			$client = new \TmApi\Client(Yii::app()->user->identity->apiKey);
			$movies = new \TmApi\Rest\Movies($client);
			$data = $movies->info($id, [
				'language' => Yii::app()->language,
			]);
			$movie = new \TmApi\Model\Movie($client, $data);

			// creates new Movies model
			$model = new Movies();
			$model->movie_id = $movie->id;
			$model->title = $movie->title;
			$model->original_title = $movie->original_title;
			$model->release_date = $movie->release_date;
			$model->runtime = $movie->runtime;
			$model->overview = $movie->overview;

			$genres = [];
			if(is_array($movie->genres)) {
				foreach($movie->genres as $genre) {
					$genres[] = $genre->name;
				}
			}
			$model->genres = implode(', ', $genres);

			// save original poster file
			$model->poster_path = $movie->poster_path;
			$movie->getPoster()->save($model->getPosterFullPath());

			if(!$model->save()) {
				throw new Exception("Error saving movie model");
			}
		}

		return $model;
	}
}