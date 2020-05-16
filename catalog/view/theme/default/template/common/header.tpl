<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head itemscope itemtype="http://schema.org/WPHeader">
    <!-- Anti-flicker snippet (recommended)  -->
    <style>.async-hide { opacity: 0 !important} </style>
    <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
        h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
                (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
                })(window,document.documentElement,'async-hide','dataLayer',4000,
                {'GTM-MV8363J':true});</script>

    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php foreach ($links as $link) { ?>
    <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>"/>
    <?php } ?>

    <base href="<?php echo $base; ?>"/>

    <?php if ($description) { ?>
    <meta itemprop="description" name="description" content="<?php echo $description; ?>"/>
    <?php } ?>

    <?php if ($keywords) { ?>
    <meta itemprop="keywords" name="keywords" content="<?php echo $keywords; ?>"/>
    <?php } ?>

    <meta name='yandex-verification' content='4b0915898cd875bc'/>
    <meta name="google-site-verification" content="yXwaN6HpgmDIwweFiF0vcJx25VdiwevqI-YIVoCeGQM"/>

    <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="catalog/view/theme/default/stylesheet/fonts.css?version=<?php echo SITE_VERSION; ?>" rel="stylesheet"/>

    <?php foreach ($styles as $style) { ?>
    <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>"
          media="<?php echo $style['media']; ?>"/>
    <?php } ?>

    <link href="catalog/view/theme/default/stylesheet/main.css?version=<?php echo SITE_VERSION; ?>" rel="stylesheet"
          type="text/css"/>
    <link href="catalog/view/javascript/mmenu/jquery.mmenu.all.css?version=<?php echo SITE_VERSION; ?>" rel="stylesheet"
          type="text/css"/>

    <?php if ($jquery311) { ?>
    <script src="<?php echo $jquery311; ?>" type="text/javascript"></script>
    <?php } ?>

    <?php if ($jquery_ui) { ?>
    <script src="<?php echo $jquery_ui; ?>" type="text/javascript"></script>
    <?php } ?>


    <?php foreach ($analytics as $analytic) { ?>
    <?php echo $analytic; ?>
    <?php } ?>

    <?php if ($opgh) { ?>
    <meta property="og:title" content="<?php echo $opgh['title'];?>"/>
    <meta property="og:description" content="<?php echo $opgh['description'];?>"/>
    <meta property="og:image" content="<?php echo $opgh['img'];?>">
    <meta property="og:type" content="<?php echo $opgh['type'];?>"/>
    <meta property="og:url" content="<?php echo $opgh['url'];?>"/>
    <?php } ?>

    <title itemprop="headline"><?php echo $title; ?></title>

    <?php echo $header_scripts; ?>

</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MV8363J"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<header>

    <?php echo $shipping_info; ?>

    <?php echo $menu_mobile; ?>

    <div id="top_mins" class="container-fluid visible-sm visible-xs">
        <div class="row">
            <div class="col-xs-5">
                <a href="#mini_menu"><i class="fas fa-bars"></i></a>
            </div>
            <div class="col-xs-3"></div>

            <div class="hidden-sm">
                <div class="col-xs-2">
                    <a href="<?php echo $account; ?>" class="mob_icon">
                        <img src="catalog/view/theme/default/img/kabinet.png" alt="" class="img-responsive"/>
                    </a>
                </div>
                <div class="col-xs-2">
                    <a href="<?php echo $shopping_cart; ?>" class="mob_icon">
                        <div class="top_link_cart_and_icon">
                            <img src="catalog/view/theme/default/img/korz.png" alt="" class="img-responsive"/>
                            <div class="cnt_cart"><?php echo $text_items; ?></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div itemscope itemtype="http://schema.org/Organization" id="top" class="container">
        <div class="row">
            <p class="visible-xs"><br><br></p>
            <div class="col-xs-6 col-xs-offset-3 col-sm-3 col-sm-offset-0 col-md-3">
                <div id="logo" class="text-center" >
                    <?php if (!empty($logo_href)) { ?>
                    <a itemprop="logo" href="<?php echo $logo_href; ?>" itemprop="url">
                        <img class="img-responsive" src="image/<?php echo $logo; ?>" alt="NORWEGIAN Fish Oil" >
                    </a>
                    <?php } else { ?>
                        <img itemprop="logo" class="img-responsive" src="image/<?php echo $logo; ?>" alt="NORWEGIAN Fish Oil" >
                    <?php }?>
                </div>
            </div>
            <div class="add_text col-md-3 visible-xl">
                <p>Омега-3 из Норвегии.<br>Производим с 1936 года</p>
            </div>

            <!-- Hidden block schema only-->
            <div style="position: absolute; opacity: 0; visibility: hidden;">
                <p itemprop="name" >NORWEGIAN Fish Oil</p>
                <div itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">  
                    <span itemprop="postalCode">21357</span>, 
                    <span itemprop="addressCountry">Россия</span>, 
                    <span itemprop="addressRegion">Московская область</span>, 
                    <span itemprop="addressLocality">Москва</span>, 
                    <span itemprop="streetAddress">Верейская, д.29 стр.134, БЦ Верейская Плаза 3</span>
                </div> 
            </div>
            <!-- End Hidden block schema only-->

            <div class="col-sm-2 hidden-xs">
                <div class="pull-right text-left top_phone" >
                    <p><a itemprop="telephone" href="tel:+7 (800) 707 88 97" ><?php echo $telephone; ?></a></p>
                    <span>Звонок бесплатный</span>
                </div>
            </div>

            <div id="gray_grade_line" class="hidden-sm hidden-xs"></div>

            <div class="col-sm-4 hidden-xs">
                <div class="line_vert hidden-sm"></div>
                <ul class="list-unstyled top_links">
                    <li class="top_link"><a class="top_link_kabinet"><img
                                    src="catalog/view/theme/default/img/kabinet.png" alt="Вход в личный кабинет"/>Кабинет</a>

                        <div class="dropmenu">

                            <?php if ($logged) { ?>

                            <p><?php echo $text_account; ?></p>
                            <hr/>
                            <div class="top_account_links">
                                <p><a href="<?php echo $order; ?>"><i class="fas fa-list"></i> Мои заказы</a></p>
                                <p><a href="<?php echo $edit; ?>"><i class="fas fa-address-card"></i> Личные
                                        настройки</a></p>
                                <p><a href="<?php echo $address; ?>"><i class="fas fa-cube"></i> Адрес доставки</a></p>
                            </div>
                            <br/>
                            <hr/>

                            <div class="top_account_links">
                                <p class="control-label top_logout"><i class="fas fa-sign-out-alt"></i> <a
                                            href="<?php echo $logout; ?>">Выход</a>
                                </p>
                            </div>

                            <?php } else { ?>

                            <div class="col-sm-12 col-xs-12">
                                <form action="<?php echo $login; ?>" method="post"
                                      enctype="multipart/form-data">
                                    <br/>
                                    <div class="text-left">
                                        <label class="control-label">Логин</label>
                                        <input class="form-control" name="email" type="text" placeholder="Ваш email"
                                               maxlength="32"/>
                                        <br/>
                                        <label class="control-label">Пароль <a class="forgotten_top"
                                                                               href="<?php echo $forgotten; ?>">Забыли
                                                пароль?</a></label>
                                        <input class="form-control" name="password" type="password"
                                               placeholder="Ваш пароль" maxlength="32"/>
                                        <br/>
                                        <p><input type="submit" class="btn prim_btn" value="Вход"></p>

                                        <small><a class="register_link_top"
                                                  href="<?php echo $register; ?>">Регистрация</a>
                                        </small>
                                    </div>
                                </form>
                            </div>

                            <?php } ?>

                        </div>
                    </li>
                    <li class="top_link">
                        <a class="top_link_cart">
                            <div class="top_link_cart_and_icon">
                                <img src="catalog/view/theme/default/img/korz.png"
                                     alt="Корзина"/> Корзина
                                <div class="cnt_cart"><?php echo $text_items; ?></div>
                            </div>

                        </a>
                        <div class="dropmenu">
                            <?php echo $cart; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr class="top_hr"/>
    <div id="top_menu" class="container hidden-sm hidden-xs">
        <?php echo $menu; ?>
    </div>

</header>

<body class="<?php echo $class; ?>">

<div id="dark"></div>
<div id="quick_order" class="dialogs"></div>
<div id="call_form" class="dialogs"></div>
<div id="login" class="dialogs"></div>

<div id="added_to_cart" class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <br/>
                <div class="text-left added-style">Товар добавлен в корзину</div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <br/>
                <a href="<?php echo $cart_link;?>" class="to_cart_link">Перейти в корзину
                    <img src="image/cart_min.png" alt=""/>
                </a>
            </div>

            <div class="col-xs-12 col-sm-5">
                <br/>
                <button class="contu_pay">Продолжить покупки <img src="image/left-arrow.svg" alt="Продолжить покупки"/>
                </button>
            </div>
        </div>
    </div>
</div>