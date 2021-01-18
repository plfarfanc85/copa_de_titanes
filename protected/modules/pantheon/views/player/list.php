<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li class="active">Jugadores</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Jugadores <small>Lista</small></h1>


<!-- begin row -->
<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <?php echo CHtml::link("Crear",Yii::app()->createUrl("pantheon/player/create"),array('class'=>'btn btn-success btn-xs')); ?>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <!--<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Lista de Jugadores</h4>
            </div>
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Username</th>
                            <th>Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $criteria = $model->search()->getCriteria() ?>
                    	<?php $criteria->addCondition('state IN (0,1)'); ?>
        				<?php $data = Player::model()->findAll($criteria); ?>
        				<?php foreach ($data as $key => $value): ?>
                        <tr class="odd gradeX">
                            <td><?php echo CHtml::link($value->name,Yii::app()->createUrl("pantheon/player/update",array('id'=>$value->id))); ?></td>
                            <td><?php echo $value->surname ?></td>
                            <td><?php echo $value->username ?></td>
                            <td><?php echo $value->dni ?></td>
                            <td><?php echo $value->mobile ?></td>
                            <td><?php echo $value->email ?></td>
                            <td><?php echo $value->getState() ?></td>
                        </tr>
                    	<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-12 -->
</div>
<!-- end row -->