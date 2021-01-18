<?php 
$columns=$model->attributeNames();
$dataProvider=$model->search();
$dataProvider->setPagination(false);
$this->controller->widget('tii.pdf.EPDFGrid', array(
    'id'        => 'report-pdf',
    'fileName'  => 'Report on PDF',// name file without (.pdf)
    'dataProvider'  => $dataProvider,
    'columns'   => array_slice($columns,0,5),
        /*array(
            'name'  => 'columnName4',
            'value' => '$data->relationName->value',
        ),*/
    'config'    => array(
        'title'     => get_class($model),
        'subTitle'  => Yii::t('app','Report of').' '.get_class($model),
        #'colWidths' => array(40, 90, 40, 70),
    ),
));
 ?>