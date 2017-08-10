<!DOCTYPE html>
<html lang="en">
<?= $this->render('/layouts/head')?>

<body class="login-layout">
<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <i class="icon-leaf green"></i>
                            <span class="red">Ace</span>
                            <span class="white">Application</span>
                        </h1>
                        <h4 class="blue">&copy; 杭州风远科技有限公司</h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                        <i class="icon-coffee green"></i>
                                        请输入你的信息
                                    </h4>

                                    <div class="space-6"></div>

                                    <?php if(count($model->errors) > 0){?>
                                        <div class="alert alert-danger">
                                            <ul>
                                                <?php foreach ($model->errors as $error){?>
                                                    <li><?= $error[0]?></li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    <?php }?>

                                    <form action="login" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken?>">
                                        <fieldset>
                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" name="LoginForm[username]" class="form-control" placeholder="用户名" />
															<i class="icon-user"></i>
														</span>
                                            </label>

                                            <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="LoginForm[password]" class="form-control" placeholder="密码" />
															<i class="icon-lock"></i>
														</span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <label class="inline">
                                                    <input type="checkbox" name="LoginForm[rememberMe]" onclick="this.value=this.checked?1:0" class="ace" />
                                                    <span class="lbl"> 记住我</span>
                                                </label>

                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="icon-key"></i>
                                                    登录
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>

                                </div><!-- /widget-main -->

                            </div><!-- /widget-body -->
                        </div><!-- /login-box -->

                    </div><!-- /position-relative -->
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>-->

<!-- <![endif]-->

<!--[if IE]>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/component/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/component/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

</body>
</html>
