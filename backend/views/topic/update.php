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
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >主题名称:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="text" value="<?= $model->title?>" name="title" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >封面:</label>
                            <div class="col-sm-9">
                                <div class="clearfix col-sm-9">
                                    <input id="input-id" type="file" class="file" data-preview-file-type="text" >
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
        $("#input-id").fileinput({
            showCaption: false,
            maxFileSize: 1024 * 2,
            enctype:'multipart/form-data',
            browseLabel: "Pick Image",
            browseOnZoneClick : false,
            autoReplace: true,
            uploadUrl:'/upload/index',
            maxFileCount : 1,
            uploadExtraData:{
                "type" : 1 ,
                "_csrf-backend" : $('meta[name=csrf-token]').attr('content'),
            }
        }).on("fileuploaded",function(event,data,previewId,index){
            $('#'+previewId).attr('data-imgSrc',data.response.url);
        });
        $('#submit').click(function(){
            $('#create-model-form').submit();
        });
        $('#create-model-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            rules: {
                position: {
                    required: true,
                    min: 1,
                    number:true,
                },
                title: {
                    required: true,
                },
            },

            messages: {
                position:{
                    required:'请输入位置',
                    min:'请输入数字大于1',
                    number:'请输入数字',
                },
                title:{
                    required:'标题不能为空',
                },
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
                $('#create-model-form').ajaxSubmit({
                    url:'create',
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