<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
	<li><a href="javascript:;">Inicio</a></li>
	<li><a href="javascript:;">Perfil</a></li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Perfil <small>Datos personales y imagen.</small></h1>
<!-- end page-header -->
<!-- begin profile-container -->
<div class="profile-container">
    <!-- begin profile-section -->
    <div class="profile-section">
        <!-- begin profile-left -->
        <div class="profile-left">
            <!-- begin profile-image -->
            <div class="profile-image">
                <img src="<?php echo Yii::app()->baseUrl.$player->path ?>" width="100%" />
                <i class="fa fa-user hide"></i>
            </div>
            <!-- end profile-image -->
            <div class="m-b-10">
                <!--<a href="#" class="btn btn-warning btn-block btn-sm">Cambiar Foto</a>-->
                <a href="#modal-dialog-1" class="btn btn-warning btn-block btn-sm" data-toggle="modal">Cambiar Foto</a>
                <a href="#modal-dialog-2" class="btn btn-success btn-block btn-sm" data-toggle="modal">Actualizar Datos</a>
            </div>
            <?php /*
            <!-- begin profile-highlight -->
            <div class="profile-highlight">
                <h4><i class="fa fa-cog"></i> Only My Contacts</h4>
                <div class="checkbox m-b-5 m-t-0">
                    <label><input type="checkbox" /> Show my timezone</label>
                </div>
                <div class="checkbox m-b-0">
                    <label><input type="checkbox" /> Show i have 14 contacts</label>
                </div>
            </div>
            */ ?>
            <!-- end profile-highlight -->
        </div>
        <!-- end profile-left -->
        <!-- begin profile-right -->
        <div class="profile-right">
            <!-- begin profile-info -->
            <div class="profile-info">
                <!-- begin table -->
                <div class="table-responsive">
                    <table class="table table-profile">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h4><?php echo $player->name ?><small><?php echo $player->surname ?></small></h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="highlight">
                                <td class="field">Username</td>
                                <td><?php echo $player->username ?></td>
                            </tr>
                            <tr class="divider">
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="field">Cedula</td>
                                <td><?php echo $player->dni ?></td>
                            </tr>
                            <tr>
                                <td class="field">Email</td>
                                <td><?php echo $player->email ?></td>
                            </tr>
                            <tr>
                                <td class="field">Celular</td>
                                <td><i class="fa fa-mobile fa-lg m-r-5"></i> <?php echo $player->mobile ?></td>
                            </tr>
                            <tr>
                                <td class="field">Ciudad</td>
                                <td><?php echo @$player->city->name ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end table -->
            </div>
            <!-- end profile-info -->
        </div>
        <!-- end profile-right -->
    </div>
    <!-- end profile-section -->
</div>
<!-- end profile-container -->
	

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'console-form',
  'action'=>Yii::app()->createUrl("torneos/usuario/fotoPerfil"),
  'type'=>'horizontal',
  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
  'method'=>'post',
)); ?>
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Actualizar Foto</h4>
            </div>
            <div class="modal-body">
                <label>Adjunte la imágen de su perfil, por favor no subir imágenes que pesen más de 100 kb.</small></label>
                <?php echo $form->fileField($perfilForm,'path');  ?>
                <?php echo $form->error($perfilForm,'path'); ?>

                <input name="inscripcion_id" id="id_incripcion1" value="" type="hidden">
            </div>
            <div class="modal-footer">
                <!--<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>-->
                <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                <button class="btn btn-sm btn-white" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

    
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'console-form',
  'action'=>Yii::app()->createUrl("torneos/usuario/perfil"),
  'type'=>'horizontal',
  'htmlOptions'=>array('enctype'=>'multipart/form-data'),
  'method'=>'post',
)); ?>
<!-- #modal-dialog -->
<div class="modal fade" id="modal-dialog-2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Actualizar Datos</h4>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <?php echo $form->label($player,'name',array('class'=>'col-md-3 control-label'));  ?>
                    <div class="col-md-8">
                    <?php echo $form->textField($player,'name',array('class'=>'form-control'));  ?>
                    <?php echo $form->error($player,'name'); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo $form->label($player,'surname',array('class'=>'col-md-3 control-label'));  ?>
                    <div class="col-md-8">
                    <?php echo $form->textField($player,'surname',array('class'=>'form-control'));  ?>
                    <?php echo $form->error($player,'surname'); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo $form->label($player,'username',array('class'=>'col-md-3 control-label'));  ?>
                    <div class="col-md-8">
                    <?php echo $form->textField($player,'username',array('class'=>'form-control'));  ?>
                    <?php echo $form->error($player,'username'); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo $form->label($player,'dni',array('class'=>'col-md-3 control-label'));  ?>
                    <div class="col-md-8">
                    <?php echo $form->textField($player,'dni',array('class'=>'form-control'));  ?>
                    <?php echo $form->error($player,'dni'); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo $form->label($player,'email',array('class'=>'col-md-3 control-label'));  ?>
                    <div class="col-md-8">
                    <?php echo $form->textField($player,'email',array('class'=>'form-control'));  ?>
                    <?php echo $form->error($player,'email'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $form->label($player,'mobile',array('class'=>'col-md-3 control-label'));  ?>
                    <div class="col-md-8">
                    <?php echo $form->textField($player,'mobile',array('class'=>'form-control'));  ?>
                    <?php echo $form->error($player,'mobile'); ?>
                    </div>
                </div> 
                <div class="form-group">
                    <?php echo $form->label($player,'city_id',array('class'=>'col-md-3 control-label'));  ?>
                    <div class="col-md-8">
                    <?php echo $form->dropDownList($player,'city_id',City::model()->getList(),array('class'=>'col-md-3 control-label'));  ?>
                    <?php echo $form->error($player,'city_id'); ?>
                    </div>
                </div> 

                <input name="inscripcion_id" id="id_incripcion1" value="" type="hidden">
            </div>
            <div class="modal-footer">
                <!--<a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>-->
                <button type="submit" class="btn btn-sm btn-success">Guardar</button>
                <button class="btn btn-sm btn-white" data-dismiss="modal" aria-hidden="true">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

    
