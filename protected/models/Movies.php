<?php

/**
 * This is the model class for table "movies".
 *
 * The followings are the available columns in table 'movies':
 * @property integer $id
 * @property string $movie_id
 * @property string $title
 * @property string $original_title
 * @property string $release_date
 * @property string $runtime
 * @property string $overview
 * @property string $genres
 * @property string $poster_path
 */
class Movies extends CActiveRecord
{
	public $poster_image;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'movies';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title, original_title, poster_path', 'required'),
			array('title, original_title, poster_path', 'length', 'max'=>255),
			array('release_date', 'date', 'format' => 'yyyy-MM-dd'),
			array('runtime', 'numerical', 'integerOnly'=>true),
			array('poster_image', 'file', 'types' => 'jpg, jpeg, gif, png', 'allowEmpty'=>true),
			array('genres, overview', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'movie_id' => 'Movie ID',
			'title' => 'Title',
			'original_title' => 'Original Title',
			'release_date' => 'Release Date',
			'runtime' => 'Runtime',
			'overview' => 'Overview',
			'genres' => 'Genres',
			'poster_path' => 'Poster Path',
			'poster_image' => 'Poster Image',
		);
	}

	/**
	 * Before model save actions
	 * @return bool
	 */
	protected function beforeSave()
	{
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
//				if($this->poster_path) {
//					// save original poster file
//					$client = new \TmApi\Client(Yii::app()->user->identity->apiKey);
//					$posterImageName = Yii::getPathOfAlias('webroot.posters') . $this->poster_path;
//					if(!file_exists($posterImageName)) {
//						$movie = new \TmApi\Model\Movie($client, $this);
//						$movie->getPoster()->save($posterImageName);
//					}
//				}
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Returns full path to movie poster file
	 * @return string
	 */
	public function getPosterFullPath()
	{
		return Yii::getPathOfAlias('webroot.posters') . $this->poster_path;
	}

	/**
	 * Returns url to movie poster
	 * @param boolean $cache
	 * @return string
	 */
	public function getPosterUrl($cache = true)
	{
		$url = Yii::app()->request->baseUrl . '/posters' . $this->poster_path;
		if($cache === false) {
			$url .= "?t=" . time();
		}
		return $url;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Movies the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
