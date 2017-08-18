<?php
use common\models\Activity;
/** @var $model common\models\OfflineActivity */
$activities = Activity::find()->all();
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
                <li class="active">APP管理设置</li>
            </ul><!-- .breadcrumb -->
        </div>
        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <form id="create-model-form" class="form-horizontal" role="form">

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >所属活动:</label>

                            <div class="col-xs-12 col-sm-9" >
                                <select class="chosen-select" name="activity_id" style="width: 480px">
                                    <option></option>
                                    <?php foreach ($activities as $activity){?>
                                        <option <?php if($model->activity_id == $activity->id){echo 'selected';}?> value="<?= $activity->id?>"><?= $activity->title?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >活动城市:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input  name="location"  value="<?= $model->location?>" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >活动城市英文名:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input  name="en_location" value="<?= $model->en_location?>" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >报名结束时间:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input  name="end_time" value="<?= $model->end_time?date('Y-m-d',$model->end_time):'' ?>" class="col-xs-12 col-sm-6 date-picker">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >报名费用:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="number" name="price" value="<?= $model->price?>" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >益走最小公里数:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="number" name="min_walk" value="<?= $model->benefit_walk_min?>" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >益走最大公里数:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="number" name="max_walk" value="<?= $model->benefit_walk_max?>" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>


                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" > 详情介绍:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <textarea id="editor" name="desc" ><?= $model->desc?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" > 英文详情介绍:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <textarea id="editor2" name="en_desc" ><?= $model->en_desc?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="button" id="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    保存
                                </button>
                                &nbsp; &nbsp;
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!-- /.main-content -->
<?php $this->beginBlock('scripts')?>
    <link href="/plugins/chosen/chosen.min.css" media="all" rel="stylesheet" type="text/css" >

    <script src="/plugins/chosen/chosen.jquery.min.js" type="text/javascript"></script>
    <link href="/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <!-- piexif.min.js is only needed if you wish to resize images before upload to restore exif data.
         This must be loaded before fileinput.min.js -->
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
         This must be loaded before fileinput.min.js -->
    <script src="/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
         This must be loaded before fileinput.min.js -->
    <script src="/js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <script src="/js/fileinput.min.js"></script>
    <!-- bootstrap.js below is needed if you wish to zoom and view file content
         in a larger detailed modal dialog -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- optionally if you need a theme like font awesome theme you can include
        it as mentioned below -->
    <script src="/themes/fa/theme.js"></script>
    <!-- optionally if you need translation for your language then include
        locale file as mentioned below -->
    <script src="/js/locales/zh.js"></script>
    <link rel="stylesheet" href="/plugins/datetimepicker/jquery.datetimepicker.css" />
    <script src="/plugins/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <script>
        var editor = new Simditor({
            textarea: $('#editor'),
            toolbar: [
                'title',
                'bold',
                'italic',
                'underline',
                'strikethrough',
                'fontScale',
                'color',
                'ol'  ,
                'ul',
                'blockquote',
                'code'   ,
                'table',
                'link',
                'image',
                'hr'    ,
                'indent',
                'outdent',
                'alignment',
            ],
            upload: {
                url: '/upload/sim-upload', //文件上传的接口地址
                params: {
                    type : 2,
                    '_csrf-backend' : $('meta[name="csrf-token"]').attr('content'),
                }, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交
                connectionCount: 3,
                leaveConfirm: '正在上传文件',
            },
        });
        var editor2 = new Simditor({
            textarea: $('#editor2'),
            toolbar: [
                'title',
                'bold',
                'italic',
                'underline',
                'strikethrough',
                'fontScale',
                'color',
                'ol'  ,
                'ul',
                'blockquote',
                'code'   ,
                'table',
                'link',
                'image',
                'hr'    ,
                'indent',
                'outdent',
                'alignment',
            ],
            upload: {
                url: '/upload/sim-upload', //文件上传的接口地址
                params: {
                    type : 2,
                    '_csrf-backend' : $('meta[name="csrf-token"]').attr('content'),
                }, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交
                connectionCount: 3,
                leaveConfirm: '正在上传文件',
            },
        });
        $(".chosen-select").chosen({
            no_results_text:'没有找到你想要的',
            allow_single_deselect:true,
            max_selected_options:1,
            search_contains: true,
        });
        $('.date-picker').datetimepicker({
            lang:'ch',
            format : 'Y-m-d H:i',
            timepicker: false,
            scrollMonth:false,
            scrollTime:false,
            scrollInput:false,
        });

        $('#submit').click(function(){
            $('#create-model-form').submit();
        });
        $.validator.addMethod("walk_limit", function(value, element) {
            var returnVal = false;
            var min_walk = $('input[name=min_walk]').val();
            var max_walk = $('input[name=max_walk]').val();
            if(parseFloat(max_walk) > parseFloat(min_walk)){
                returnVal = true;
            }
            return returnVal;
        },"最大公里数必须大于最小公里数");
        $('#create-model-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            rules: {
               location:{
                   required:true,
               },
               en_location :{
                   required:true,
               },
               end_time :{
                   required:true,
               },
               price:{
                   required:true,
                    number:true,
                    min:0,
                },
               max_walk :{
                   walk_limit:true
               }
            },

            messages: {
                location:{
                    required:'活动城市不能为空',
                },
                en_location :{
                    required:'活动城市不能为空',
                },
                end_time :{
                    required:'报名结束时间不能为空',
                },
                price:{
                    required:'报名价格不能为空',
                    number:'请输入数字',
                    min:'最小为0',
                }
            },

            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },

            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error').addClass('has-info');
                $(e).remove();
            },

            errorPlacement: function (error, element) {
                if(element.is(':checkbox') || element.is(':radio')) {
                    var controls = element.closest('div[class*="col-"]');
                    if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if(element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                }
                else if(element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },

            submitHandler: function (form) {
                var filePath = [];
                $('[data-imgSrc]').each(function() {
                    filePath.push($(this).attr('data-imgSrc'));
                });
                $('.main-content').showLoading();
                var id = '<?= $model->id ?>';
                $('#create-model-form').ajaxSubmit({
                    url:'update?id='+id,
                    dataType:'json',
                    type:'post',
                    enctype: 'multipart/form-data',
                    data : {
                        filePath: filePath,
                        '_csrf-backend':$('meta[name=csrf-token]').attr('content'),
                    },
                    error:function(result){
                        $('.main-content').hideLoading();
                        gritterError(result.responseText);
                    },
                    success:function(data){
                        $('.main-content').hideLoading();
                        if(data == 1){
                            gritterSuccess('添加成功');
                            history.go(-1);
                            window.location.reload();
                        }else{
                            gritterError(data);
                        }
                    }
                });
                return false;
            },
            invalidHandler: function (form) {
                return false;
            }
        });
    </script>
<?php $this->endBlock('scripts')?>