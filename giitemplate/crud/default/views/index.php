<?php
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
/** @var $dataProvider \yii\data\ActiveDataProvider */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

echo "<?php\n"."use yii\helpers\Html;";



?>
?>
<div class="main-content">
    <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="icon-home home-icon"></i>
                <a href="/">首页</a>
            </li>
            <li class="active">系统设置</li>
        </ul><!-- .breadcrumb -->

        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter blue"><?=StringHelper::basename($generator->modelClass)?>管理</h3>
                    <p>
                        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <div class="table-header">
                        <?=StringHelper::basename($generator->modelClass)?>列表
                    </div>

                    <div class="table-responsive">
                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <?php $i = 0;?>
                                <?php foreach($generator->getColumnNames() as $name){?>
                                    <?php if($i++ > 6){break;} ?>
                                    <th><?= $name?></th>
                                <?php }?>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?= "<?"?>php foreach($dataProvider->getModels() as $model){ ?>
                            <tr>
                                <?php $i = 0;?>
                                <?php foreach($generator->getColumnNames() as $name){?>
                                    <?php if($i++ > 6){break;} ?>
                                    <td><?= "<?"?>= $model-><?=$name?>?></td>
                                <?php }?>
                                <td>
                                    <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                        <a class="green" href="/<?=strtolower(StringHelper::basename($generator->modelClass))?>/update?id=<?= "<?"?>= $model->id?>">
                                            <i class="icon-pencil bigger-130"></i>
                                        </a>

                                        <a class="red delete-btn" data-id="<?= "<?"?>= $model->id?>" href="#">
                                            <i class="icon-trash bigger-130"></i>
                                        </a>
                                    </div>

                                    <div class="visible-xs visible-sm hidden-md hidden-lg">
                                        <div class="inline position-relative">
                                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">
                                                <i class="icon-caret-down icon-only bigger-120"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
                                                <li>
                                                    <a href="/<?=strtolower(StringHelper::basename($generator->modelClass))?>/update?id=<?= "<?"?>= $model->id?>" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                        <span class="green">
                                                            <i class="icon-edit bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#" data-id="<?= "<?"?>= $model->id?>" class="delete-btn tooltip-error" data-rel="tooltip" title="Delete">
                                                        <span class="red">
                                                            <i class="icon-trash bigger-120"></i>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?="<?"?>php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?= "<?"?>php if(isset($pagination)){?>
            <?= "<?"?>= $this->render('/pagination/pagination',[
            'pagination' => $pagination
            ])?>
            <?= "<?"?>php }?>
        </div>
    </div>
</div><!-- /.main-content -->

<script>
    $('.delete-btn').click(function () {
        if(!window.confirm('你确定要删除此项么?')){
            return false;
        }
        var id = $(this).attr('data-id');
        var $button_tr =  $(this).closest('tr');
        $.ajax({
            url : '/<?=strtolower(StringHelper::basename($generator->modelClass))?>/delete?id='+id,
            type : 'post',
            data : {
                '_csrf-backend' : $('meta[name="csrf-token"]').attr('content')
            },
            success:function (result) {
                gritterSuccess('操作成功');
                //操作成功移除本行及详情行
                $button_tr.remove();
            }

        })
    });
</script>