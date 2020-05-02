<footer>
    <div class="container-fluid footer-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="text-center">
                        <br/>
                        <img src="image/logowhite.png" alt="NORWEGIAN Fish Oil"/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-1">
                    <br/>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="foot_menu">
                        <ul class="list-unstyled">
                            <li><a href="<?php echo $menu['catalog']; ?>">Каталог продукции</a></li>
                            <li><a href="<?php echo $menu['sale']; ?>">Акции</a></li>
                            <li><a href="<?php echo $menu['about']; ?>">О компании</a></li>
                            <li><a href="<?php echo $menu['news']; ?>">Новости</a></li>
                            <li><a href="<?php echo $menu['for_experts']; ?>">Специалистам</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="foot_menu">
                        <ul class="list-unstyled">
                            <li><a href="<?php echo $menu['partners']; ?>">Партнеры</a></li>
                            <li><a href="<?php echo $menu['video']; ?>">Видео</a></li>
                            <li><a href="<?php echo $menu['faq']; ?>">Вопросы и отзывы</a></li>
                            <li><a href="<?php echo $menu['contacts']; ?>">Контакты</a></li>
                            <li><a href="<?php echo $menu['partners_programm']; ?>">Партнерская программа</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div>
                        <br/>
                        <div class="socals_foot">
                            <div class="inst"><a target="_blank" href="<?php echo $socials['instagram']; ?>"></a></div>
                            <div class="fb"><a target="_blank" href="<?php echo $socials['facebook']; ?>"></a></div>
                            <div class="yt"><a target="_blank" href="<?php echo $socials['youtube']; ?>"></a></div>
                            <div class="telegram"><a target="_blank" href="<?php echo $socials['telegram']; ?>"></a></div>
                        </div>
                    </div>
                    <br/>
                    <div>
                        <br/>
                        <br/>
                        <?php echo $share_button; ?>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row" id="footer-bottom">
                <hr/>
                <div class="col-sm-5">
                    <p class="copy"><?php echo $years; ?> NORWEGIAN Fish Oil - Рыбий жир в капсулах из Норвегии</p>
                    <p>БАД, не является лекарством</p>
                </div>
                <div class="col-sm-3">
                    <p><a href="<?php echo $menu['privacy']; ?>" class="privacy_link">Пользовательское соглашение</a>
                    </p>
                </div>
                <div class="col-sm-4">
                    <div class="text-left">
                        <img src="image/visa_gray.png" alt=""/> <img src="image/master_gray.png" alt=""/>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($modals) { ?>
        <?php foreach ($modals as $modal) { ?>
            <?php echo $modal; ?>
        <?php } ?>
    <?php } ?>

    <?php echo $scroll_up; ?>

    <input type="hidden" id="show-action-modal" value="0" />
    <input type="hidden" id="gentleIronExpirationDays" value="<?php echo $gentleIronExpirationDays; ?>" />

</footer>

<?php if ($jquery_link) { ?>
<script src="<?php echo $jquery_link; ?>" type="text/javascript"></script>
<?php } ?>

<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/jquery.maskedinput.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/GtmECommerce.js?version=<?php echo SITE_VERSION; ?>" type="text/javascript"></script>
<script src="catalog/view/javascript/fbq.js?version=<?php echo SITE_VERSION; ?>" type="text/javascript"></script>
<script src="catalog/view/javascript/common.js?version=<?php echo SITE_VERSION; ?>" type="text/javascript"></script>

<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

</body>

</html>