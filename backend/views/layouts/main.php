<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="en">
<?= $this->render('head')?>

<body id="main-body">
<?php $this->beginBody() ?>
<?= $this->render('nav')?>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <?= $this->render('left')?>

        <?= $content ?>

    </div><!-- /.main-container-inner -->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
</div>

<?= $this->render('footer')?>

<?= $this->blocks['scripts']?>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>

