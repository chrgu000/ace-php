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
    </div>
    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <form id="create-user-form" class="form-horizontal" role="form">
                    <input type="hidden" name="_csrf-backend" value="<?= \Yii::$app->request->csrfToken?>">
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">用户名:</label>
                        <div class="col-xs-12 col-sm-9">
                            <div class="clearfix">
                                <input type="text" name="username" class="col-xs-12 col-sm-6">
                            </div>
                        </div>
                    </div>
                    <div class="space-8"></div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">密码:</label>

                        <div class="col-xs-12 col-sm-9">
                            <div class="clearfix">
                                <input type="password" name="password" id="password" class="col-xs-12 col-sm-6">
                            </div>
                        </div>
                    </div>
                    <div class="space-8"></div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">确认密码:</label>

                        <div class="col-xs-12 col-sm-9">
                            <div class="clearfix">
                                <input type="password" name="password2" class="col-xs-12 col-sm-6">
                            </div>
                        </div>
                    </div>
                    <div class="space-8"></div>
                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">昵称:</label>

                        <div class="col-xs-12 col-sm-9">
                            <div class="clearfix">
                                <input type="text" name="nickname" class="col-xs-12 col-sm-6">
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
    jQuery(function ($) {
        $('#submit').click(function(){
            $('#create-user-form').submit();
        });
        $('#create-user-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            rules: {
                username: {
                    required: true,
                    minlength: 4
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password2: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                nickname: {
                    required: true
                }
            },

            messages: {
                username:{
                    required:'请输入用户名称',
                    minlength:'至少4个字符',
                },
                password:{
                    required:'请输入密码',
                    minlength: '至少6个字符',
                },
                password2:{
                    required:'请输入密码',
                    minlength: '至少6个字符',
                    equalTo:'密码不一致',
                },
                nickname:{
                    required:'请输入昵称',
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
                $('.main-content').showLoading();
                $('#create-user-form').ajaxSubmit({
                    url:'create',
                    dataType:'json',
                    type:'post',
                    enctype: 'multipart/form-data',
                    error:function(result){
                        $('.main-content').hideLoading();
                        gritterError(result.responseText);
                    },
                    success:function(data){
                        $('.main-content').hideLoading();
                        if(data == 1){
                            gritterSuccess('用户添加成功');
                            window.history.back();
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
    })

</script>
<?php $this->endBlock('scripts')?>