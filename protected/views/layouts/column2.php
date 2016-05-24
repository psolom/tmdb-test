<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div id="content">

	<div style="float: right">
		<?php $this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		)); ?>
	</div>

	<?php echo $content; ?>
</div><!-- content -->

<?php $this->endContent(); ?>