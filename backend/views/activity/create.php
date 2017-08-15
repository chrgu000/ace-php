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
                        <input type="hidden" id="csrf" name="<?= \Yii::$app->request->csrfParam?>" value="<?= \Yii::$app->request->csrfToken?>">
                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >活动名称:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="text" name="title" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >英文名称:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="text" name="en_title" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >活动所在城市:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="text" name="city" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >城市英文名称:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="text" name="en_city" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >活动报名费:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input type="number" name="price" class="col-xs-12 col-sm-6">
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">活动开始时间:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input value="" name="start_time" class="col-xs-12 col-sm-6 date-picker" >
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">报名结束时间:</label>

                            <div class="col-xs-12 col-sm-9">
                                <div class="clearfix">
                                    <input value=""  name="join_end_time" class="col-xs-12 col-sm-6 date-picker" >
                                </div>
                            </div>
                        </div>
                        <div class="space-8"></div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >活动详情:</label>

                            <div class="col-xs-8">
                                <div class="wysiwyg-editor" id="editor"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" >封面:</label>
                            <div class="col-sm-9">
                                <div class="clearfix col-sm-9">
                                    <input multiple id="input-id"  type="file" class="file" data-preview-file-type="text" >
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

    <script>
        function showErrorAlert (reason, detail) {
            var msg='';
            if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
            else {
                console.log("error uploading file", reason, detail);
            }
            $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
                '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
        }
        $('#editor').ace_wysiwyg({
            toolbar:
                [
                    'font',
                    null,
                    'fontSize',
                    null,
                    {name:'bold', className:'btn-info'},
                    {name:'italic', className:'btn-info'},
                    {name:'strikethrough', className:'btn-info'},
                    {name:'underline', className:'btn-info'},
                    null,
                    {name:'insertunorderedlist', className:'btn-success'},
                    {name:'insertorderedlist', className:'btn-success'},
                    {name:'outdent', className:'btn-purple'},
                    {name:'indent', className:'btn-purple'},
                    null,
                    {name:'justifyleft', className:'btn-primary'},
                    {name:'justifycenter', className:'btn-primary'},
                    {name:'justifyright', className:'btn-primary'},
                    {name:'justifyfull', className:'btn-inverse'},
                    null,
                    {name:'createLink', className:'btn-pink'},
                    {name:'unlink', className:'btn-pink'},
                    null,
                    {name:'insertImage', className:'btn-success'},
                    null,
                    'foreColor',
                    null,
                    {name:'undo', className:'btn-grey'},
                    {name:'redo', className:'btn-grey'}
                ],
            'wysiwyg': {

            }
        }).prev().addClass('wysiwyg-style2');


        $(".chosen-select").chosen({
            no_results_text:'没有找到你想要的',
            allow_single_deselect:true,
            max_selected_options:1,
            search_contains: true,
        });
        $('.date-picker').datetimepicker({
            lang:'ch',
            format : 'Y-m-d',
            timepicker: false,
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
                "type" : 2 ,
                "_csrf-backend" : $('#csrf').val(),
            },
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