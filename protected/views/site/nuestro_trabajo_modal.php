<!-- begin row -->
<div class="row row-space-10">
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <div class="work">
            <div class="image">
                <a data-toggle="modal" data-target="#modal-dialog-perfil"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/perfil.jpg" alt="Work 1" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Perfil</span>
                <span class="desc-text">Datos personales del usuario.</span>
            </div>
        </div>
        <!-- end work -->
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <div class="work">
            <div class="image">
                <a data-toggle="modal" data-target="#modal-dialog-desempeno"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/desempeno.jpg" alt="Work 3" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Desempeño</span>
                <span class="desc-text">Datos estadisticos del hisotorial del usuario.</span>
            </div>
        </div>
        <!-- end work -->
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <div class="work">
            <div class="image">
                <a data-toggle="modal" data-target="#modal-dialog-torneos"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/torneos.jpg" alt="Work 5" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Torneos</span>
                <span class="desc-text">Podrá visualizar en detalle cada torneo.</span>
            </div>
        </div>
        <!-- end work -->
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <div class="work">
            <div class="image">
                <a data-toggle="modal" data-target="#modal-dialog-resumen"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/resumen.jpg" alt="Work 7" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Ubicación</span>
                <span class="desc-text">Cada usuario podrá ubicar su participación en cada parte del torneo (Color verde).</span>
            </div>
        </div>
        <!-- end work -->
    </div>
    <!-- end col-3 -->
</div>
<!-- end row -->
<!-- begin row -->
<div class="row row-space-10">
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <div class="work">
            <div class="image">
                <a data-toggle="modal" data-target="#modal-dialog-inscripcion"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/inscripcion.jpg" alt="Work 2" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Inscripción</span>
                <span class="desc-text">Podrá gestionar su proceso de inscripción a los torneos.</span>
            </div>
        </div>
        <!-- end work -->
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <div class="work">
            <div class="image">
                <a data-toggle="modal" data-target="#modal-dialog-calendario"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/calendario.jpg" alt="Work 4" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Calendario</span>
                <span class="desc-text">Te permitirá ver el calendario de todos los torneos.</span>
            </div>
        </div>
        <!-- end work -->
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <div class="work">
            <div class="image">
                <a data-toggle="modal" data-target="#modal-dialog-noticias"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/noticias.jpg" alt="Work 6" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Noticias</span>
                <span class="desc-text">Aquí estaremos informando los nuevos lanzamientos.</span>
            </div>
        </div>
        <!-- end work -->
    </div>
    <!-- end col-3 -->
    <!-- begin col-3 -->
    <div class="col-md-3 col-sm-6">
        <!-- begin work -->
        <!--
        <div class="work">
            <div class="image">
                <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/work-8.jpg" alt="Work 8" /></a>
            </div>
            <div class="desc">
                <span class="desc-title">Morbi bibendum pellentesque</span>
                <span class="desc-text">Lorem ipsum dolor sit amet</span>
            </div>
        </div>
        -->
        <!-- end work -->
    </div>
    <!-- end col-3 -->
</div>
<!-- end row -->



<!-- Modales -->

<!-- Perfil -->
<div class="modal fade in" id="modal-dialog-perfil">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Perfil</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/perfil.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Desempeño -->
<div class="modal fade in" id="modal-dialog-desempeno">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Desempeño</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/desempeno.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Torneos -->
<div class="modal fade in" id="modal-dialog-torneos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Torneos</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/torneos.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Resumen -->
<div class="modal fade in" id="modal-dialog-resumen">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Resumen</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/resumen.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Resumen -->
<div class="modal fade in" id="modal-dialog-resumen">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ubicación</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/resumen.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Inscripcion -->
<div class="modal fade in" id="modal-dialog-inscripcion">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Inscripción</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/inscripcion.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>


<!-- Calendario -->
<div class="modal fade in" id="modal-dialog-calendario">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Calendario</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/calendario.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

<!-- Noticias -->
<div class="modal fade in" id="modal-dialog-noticias">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Noticias</h4>
            </div>
            <div class="modal-body">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/noticias.jpg" alt="Work 1" width="100%" />
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn btn-sm btn-white" data-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
</div>

