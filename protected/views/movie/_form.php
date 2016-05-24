<?php
/* @var $this MovieController */
/* @var $model Movies */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'movies-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'original_title'); ?>
		<?php echo $form->textField($model,'original_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'original_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'release_date'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model' => $model,
			'attribute' => 'release_date',
			'language'=> Yii::app()->language,
			'options' => array(
				'dateFormat' => 'yy-mm-dd',
				'showAnim' => 'fold',
				'changeMonth' => true,
				'changeYear' => true,
				'yearRange'=>'1900:+10',
			),
		)); ?>
		<?php echo $form->error($model,'release_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'runtime'); ?>
		<?php echo $form->textField($model,'runtime'); ?>
		<?php echo $form->error($model,'runtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overview'); ?>
		<?php echo $form->textArea($model,'overview',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'overview'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'genres'); ?>
		<?php echo $form->textArea($model,'genres',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'genres'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'poster_image'); ?>
		<?php echo $form->fileField($model,'poster_image'); ?>
		<?php echo $form->error($model,'poster_image'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->