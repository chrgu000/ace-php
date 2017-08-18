<?php
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
                    <h3 class="header smaller lighter blue">线上活动详情管理</h3>
                    <p>
                        <a href="create" class="btn btn-success">创建线上活动详情</a>
                    </p>
                    <div class="table-header">
                        线上活动详情列表
                    </div>

                    <div class="table-responsive">
                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                             <th>id</th>
                            <th>活动</th>
                            <th>活动地点</th>
                            <th>英文活动地点</th>
                            <th>结束时间</th>
                            <th>报名数量</th>
                             <th></th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach($dataProvider->getModels() as $model){ ?>
                                <tr>
                                    <td><?= $model->id?></td>
                                    <td><?=$model->activity->title?></td>
                                    <td><?=$model->location?></td>
                                    <td><?=$model->en_location?></td>
                                    <td><?=date('Y-m-d H:i:s',$model->end_time)?></td>
                                    <td><?= $model->people_num?></td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                            <a class="green" href="update?id=<?= $model->id?>">
                                                <i class="icon-pencil bigger-130"></i>
                                            </a>

                                            <a class="red delete-btn" data-id="<?= $model->id?>" href="#">
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
                                                        <a href="update?id=<?= $model->id?>" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                        <span class="green">
                                                            <i class="icon-edit bigger-120"></i>
                                                        </span>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="#" data-id="<?= $model->id?>" class="delete-btn tooltip-error" data-rel="tooltip" title="Delete">
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
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php if(isset($pagination)){?>
                <?= $this->render('/pagination/pagination',[
                    'pagination' => $pagination
                ])?>
            <?php }?>
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
            url : 'delete?id='+id,
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

<?php $this->beginBlock('scripts')?>
<script src="/plugins/colorbox/jquery.colorbox-min.js"></script>

<link media="screen" rel="stylesheet" href="/plugins/colorbox/colorbox.css">

<script>
    //图片预览
    var colorbox_params = {
        rel: 'colorbox',
        reposition:true,
        scalePhotos:true,
        scrolling:false,
        previous:'<i class="ace-icon fa fa-arrow-left"></i>',
        next:'<i class="ace-icon fa fa-arrow-right"></i>',
        close:'&times;',
        current:'{current} of {total}',
        maxWidth:'100%',
        maxHeight:'100%',
        onOpen:function(){
            $overflow = document.body.style.overflow;
            document.body.style.overflow = 'hidden';
        },
        onClosed:function(){
            document.body.style.overflow = $overflow;
        },
        onComplete:function(){
            $.colorbox.resize();
        }
    };
    $('[data-rel="colorbox"]').colorbox(colorbox_params);
</script>
<?php $this->endBlock('scripts')?>
