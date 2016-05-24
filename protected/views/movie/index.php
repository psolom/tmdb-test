<?php
/* @var $this MovieController */
/* @var $filter MovieFilter */
/* @var $maxPagesNum integer */
/* @var $itemsPerPage integer */
/* @var $releaseDateStart string */
/* @var $releaseDateEnd string */

$this->pageTitle = Yii::t('app', 'Movies');
$maxResults = $maxPagesNum * $itemsPerPage;
?>

<div>
    <?php echo CHtml::link(Yii::t('app', 'Top Rated'), array($this->route, 'criteria[sort_by]' => 'popularity.desc')); ?>

    <?php echo CHtml::link(Yii::t('app', 'Now Playing'), array($this->route,
        'criteria[sort_by]' => 'primary_release_date.desc',
        'criteria[primary_release_date.gte]' => $releaseDateStart,
        'criteria[primary_release_date.lte]' => $releaseDateEnd,
    )); ?>

    <div>
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'template' => '{items} {pager}',
            'dataProvider' => $filter->getDataProvider(),
            'columns'=>array(
                array(
                    'name' => 'id',
                    'header' => Yii::t('app', 'ID'),
                ),
                array(
                    'name' => 'title',
                    'header' => Yii::t('app', 'Title'),
                ),
                array(
                    'name' => 'release_date',
                    'header' => Yii::t('app', 'Release Date'),
                ),
                array(
                    'type' => 'raw',
                    'name' => 'details',
                    'header' => Yii::t('app', 'Details'),
                    'value' => function($data, $row, $column) {
                        return CHtml::link(Yii::t('app', 'more'), array('/movie/view', 'id' => $data->id));
                    },
                ),
            ),
        )); ?>

        <?php $this->widget('CLinkPager', array(
            'currentPage' => $filter->getOption('page') - 1,
            'itemCount' => ($filter->getOption('total_results') > $maxResults) ? $maxResults : $filter->getOption('total_results'),
            'pageSize' => $itemsPerPage,
            'maxButtonCount' => 7,
            'firstPageCssClass' => 'page-first',
            'lastPageCssClass' => 'page-last',
        )); ?>
    </div>

</div>