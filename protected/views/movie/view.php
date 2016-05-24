<?php
/* @var $this MovieController */
/* @var $model Movies */
/* @var $rating integer */

$this->breadcrumbs=array(
	'Movies'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Movies', 'url'=>array('index')),
	array('label'=>'Update Movie', 'url' => array('update', 'id'=>$model->movie_id)),
	array('label'=>'Delete Movie', 'url' => '#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->movie_id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Movie: <?php echo $model->title; ?></h1>

<?php $this->widget('CStarRating', array(
	'name' => 'rating',
	'starCount' => 10,
	'maxRating' => 10,
	'readOnly' => false,
	'resetText' => 'Reset',
	'value' => round($rating, 0),
	'callback' => '
        function(value, el) {
        	var radio = $("input[type=radio]", "#rating");

        	// rate action
        	if(value >= 1 && value <= 10) {
        		$.post("/movie/rate?id=' . $model->movie_id . '&rating=" + value, function(response) {
					if (response.status == 1) {
						$("#rating-updated").show().delay(1000).fadeOut(2000);
						$("#rating-deleted").hide();
						//radio.rating("readOnly", true);
					}
				}, "json");
        	}

        	// reset action
        	if(value === undefined) {
				$.post("/movie/unrate?id=' . $model->movie_id . '", function(response) {
					if(response.status == 1) {
						$("#rating-deleted").show().delay(1000).fadeOut(2000);
						$("#rating-updated").hide();
						//radio.rating("readOnly", false);
					}
				}, "json");
        	}
		}'
)); ?>

<div id="rating-states" class="left">
	<div id="rating-updated" class="hide">Updated!</div>
	<div id="rating-deleted" class="hide">Reset!</div>
</div>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes'=>array(
		'movie_id',
		'title',
		'original_title',
		'release_date',
		'runtime',
		'overview',
		'genres',
		array (
			'name' => 'poster_path',
			'type' => 'raw',
			'value' => CHtml::image($model->getPosterUrl(false), $model->title, array(
				'width' => 600,
			)),
		),
	),
)); ?>
