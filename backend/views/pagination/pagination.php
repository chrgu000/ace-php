<?php
/** @var $pagination \yii\data\Pagination */
$currentPage = $pagination->page; //单前页 从0开始
$currentPage += 1;
$allPage = $pagination->pageCount;

?>
<div>
    <ul class="pagination">
        <li class="<?= $currentPage == 1?'disable':''?>">
            <a href="<?= $pagination->createUrl(0 , $pagination->pageSize,true)?>">
                <i class="icon-double-angle-left"></i>
            </a>

        <?php for ($i = 1 ; $i <= $allPage ; $i ++){?>
            <li class="<?= $i == $currentPage?'active':''?>">
                <a href="<?= $pagination->createUrl($i - 1, $pagination->pageSize,true)?>"><?= $i ?></a>
            </li>
        <?php }?>
        <li <?= $currentPage == $allPage?'disable':''?> >
            <a href="<?= $pagination->createUrl($allPage -1 , $pagination->pageSize,true)?>">
                <i class="icon-double-angle-right"></i>
            </a>
        </li>
    </ul>
</div>