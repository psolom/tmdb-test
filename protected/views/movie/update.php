<?php
/* @var $this MovieController */
/* @var $model Movies */

$this->breadcrumbs=array(
	'Movies'=>array('index'),
	$model->title=>array('view', 'id'=>$model->movie_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Movies', 'url'=>array('index')),
	array('label'=>'View Movies', 'url'=>array('view', 'id'=>$model->movie_id)),
	array('label'=>'Delete Movie', 'url' => '#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->movie_id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>Update Movie: <?php echo $model->title; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>