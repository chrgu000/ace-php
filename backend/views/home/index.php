<?php

$user = \Yii::$app->user->identity;
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
            <li class="active">控制台</li>
        </ul><!-- .breadcrumb -->

    </div>

    <div class="page-content">
        <div class="page-header">
            <h1>
                控制台
                <small>
                    <i class="icon-double-angle-right"></i>
                    查看
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

                <div class="alert alert-block alert-success">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="icon-remove"></i>
                    </button>

                    <i class="icon-ok green"></i>

                    欢迎使用
                    <strong class="green">
                        Ace后台管理系统
                        <small>(v1.2)</small>
                    </strong>
                    ,轻量级好用的后台管理系统模版.
                </div>

                <div class="hr dotted"></div>

                <div>
                    <div id="user-profile-1" class="user-profile row">
                        <div class="col-xs-12 col-sm-3 center">
                            <div>
                                <span class="profile-picture">
                                    <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="/img/avatars/profile-pic.jpg" />
                                </span>

                                <div class="space-4"></div>

                                <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                    <div class="inline position-relative">
                                        <span class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-circle light-green middle"></i>
                                            &nbsp;
                                            <span class="white"><?= $user->nickname?></span>
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-9">

                            <div class="space-12"></div>

                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 用户名 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="username"><?= $user->username?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 用户昵称 </div>

                                    <div class="profile-info-value">
                                        <span class="editable"><?= $user->nickname?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 创建时间 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="signup"><?= date('Y-m-d H:i',$user->created_at)?></span>
                                    </div>
                                </div>





                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 关于我们 </div>

                                    <div class="profile-info-value">
                                        <span class="editable" id="about"><a class="user-title-label" target="_blank" href="https://www.seastart.tv/">https://www.seastart.tv/<a></span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-20"></div>

                        </div>
                    </div>
                </div>


                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->

</div><!-- /.main-content -->