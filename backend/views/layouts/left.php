<div class="sidebar" id="sidebar">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>
    <ul class="nav nav-list">
        <li class="<?php if(in_array(\Yii::$app->controller->id,['','home'])){echo 'active';} ?>" >
            <a href="/">
                <i class="icon-dashboard"></i>
                <span class="menu-text"> 控制台 </span>
            </a>
        </li>

        <?php $system = ['admin-user']?>
        <li class="<?php if( in_array(\Yii::$app->controller->id, $system)){echo 'active';}?>">
            <a href="#" class="dropdown-toggle">
                <i class="icon-desktop"></i>
                <span class="menu-text"> 系统设置 </span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li class="<?= Yii::$app->controller->id == 'admin-user'?'active':''?>">
                    <a href="/admin-user/index" class="dropdown-toggle">
                        <i class="icon-double-angle-right"></i>
                        后台用户管理
                        <b class="arrow icon-angle-down"></b>
                    </a>
                </li>
            </ul>
        </li>
        <?php $app = ['topic','activity','offline-activity','online-activity']?>
        <li class="<?php if( in_array(\Yii::$app->controller->id, $app)){echo 'active';}?>">
            <a href="#" class="dropdown-toggle">
                <i class="icon-leaf"></i>
                <span class="menu-text"> APP管理设置 </span>
                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li class="<?= Yii::$app->controller->id == 'topic'?'active':''?>">
                    <a href="/topic/index" class="dropdown-toggle">
                        <i class="icon-double-angle-right"></i>
                        热门专题
                        <b class="arrow icon-angle-down"></b>
                    </a>
                </li>
                <li class="<?= Yii::$app->controller->id == 'activity'?'active':''?>">
                    <a href="/activity/index" class="dropdown-toggle">
                        <i class="icon-double-angle-right"></i>
                        热门活动
                        <b class="arrow icon-angle-down"></b>
                    </a>
                </li>
                <li class="<?= Yii::$app->controller->id == 'offline-activity'?'active':''?>" >
                    <a href="/offline-activity/index" class="dropdown-toggle">
                        <i class="icon-double-angle-right"></i>
                        线下活动详情
                        <b class="arrow icon-angle-down"></b>
                    </a>
                </li>
                <li class="<?= Yii::$app->controller->id == 'online-activity'?'active':''?>" >
                    <a href="/online-activity/index" class="dropdown-toggle">
                        <i class="icon-double-angle-right"></i>
                        线上活动详情
                        <b class="arrow icon-angle-down"></b>
                    </a>
                </li>
            </ul>
        </li>
        <?php $homepage = ['live-category','homepage-list']?>
        <li class="<?php if( in_array(\Yii::$app->controller->id, $homepage)){echo 'active';}?>">
            <a href="#" class="dropdown-toggle">
                <i class="icon-home"></i>
                <span class="menu-text"> 首页设置 </span>
                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
            </ul>

        </li>
    </ul>

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>