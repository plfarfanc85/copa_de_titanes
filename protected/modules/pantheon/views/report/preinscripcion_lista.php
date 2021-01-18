<?php if (isset($xls) && $xls==1): ?>
    <table>
        <tr>
            <th>Email</th>
            <th>Fecha</th>
        </tr>
        <?php $criteria = $model->search(1)->getCriteria() ?>
        <?php $data = EmailsCampaing::model()->findAll($criteria); ?>
        <?php foreach ($data as $key => $value): ?>
            <tr>
                <td><?php echo $value->email ?></td>
                <td><?php echo $value->date ?></td>
1            </tr>
        <?php endforeach ?>
    </table>
<?php else: ?>

<?php $this->pageTitle=Yii::app()->name; ?> 
		
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Home</a></li>
	<li class="active">Preinscripción</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Preincripción <small>Correos de los usuarios que desean jugar los torneos.</small>   <?php echo CHtml::link("<i class=\"icon-plus\"></i> Excel",Yii::app()->createUrl("pantheon/report/preinscripcion",array("Excel"=>1)), array('class'=>'btn btn-success btn-xs m-r-5')); ?></h1> 
<!-- end page-header -->

<div class="row">
	<div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">FIFA 18</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($fifa): ?>
                                <?php foreach ($fifa as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $value->id; ?></td>
                                        <td><?php echo $value->email; ?></td>
                                        <td><?php echo $value->date; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end panel -->
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-2">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">HALO</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($halo): ?>
                                <?php foreach ($halo as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $value->id; ?></td>
                                        <td><?php echo $value->email; ?></td>
                                        <td><?php echo $value->date; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end panel -->
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-3">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Mario Kart</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($mariokart): ?>
                                <?php foreach ($mariokart as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $value->id; ?></td>
                                        <td><?php echo $value->email; ?></td>
                                        <td><?php echo $value->date; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>



    <div class="col-md-6 ui-sortable">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-1">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">PES 18</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($pes): ?>
                                <?php foreach ($pes as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $value->id; ?></td>
                                        <td><?php echo $value->email; ?></td>
                                        <td><?php echo $value->date; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end panel -->
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-2">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">CALL OF DUTY</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($callofduty): ?>
                                <?php foreach ($callofduty as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $value->id; ?></td>
                                        <td><?php echo $value->email; ?></td>
                                        <td><?php echo $value->date; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end panel -->
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="table-basic-3">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">GOLDENEYE</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($goldeneye): ?>
                                <?php foreach ($goldeneye as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $value->id; ?></td>
                                        <td><?php echo $value->email; ?></td>
                                        <td><?php echo $value->date; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
</div>

<?php endif ?>