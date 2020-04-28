<?php echo $header; ?>

<?php if ($catalog_page) { ?>
    <?php echo $catalog_menu; ?>
    <input type="hidden" id="ct-active" value="<?php echo $category_id; ?>"/>
<?php } else { ?>
    <?php if (($category_id != HISTORY_CATEGORY) && ($category_id != QUALITY_CONTROL_CATEGORY)) {  ?>
    <div class="container-fluid page_title_bg">
        <div class="container textcontent">
            <h1><?php echo $heading_title; ?></h1>
        </div>
    </div>
    <?php } ?>
<?php } ?>

<?php if ($category_id == HISTORY_CATEGORY) {  // О компании  ?>
<div class="container-fluid about_company">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page_title">О компании</h1>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php if ($category_id == QUALITY_CONTROL_CATEGORY) {  // Контроль качества  ?>
<div class="container-fluid control_kach">
    <div class="container">
        <div class="row">
            <h1 class="page_title">Контроль качества</h1>
        </div>
    </div>
</div>
<?php } ?>


<div class="container">
    <div class="row">
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-7'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>

        <div id="content-transp" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <br/>
            <div class="bread fullclass">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php if ($breadcrumb['href']) { ?>
                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a> →
                <?php } else { ?>
                    <a class="current"><?php echo $breadcrumb['text']; ?> ↓</a>
                <?php } ?>
                <?php } ?>
            </div>
            <hr/>

            <?php if ($products) { ?>

            <div class="row catalog">
                <?php foreach ($products as $product) { ?>
                <div class="col-xs-12 col-sm-6  col-md-4" itemscope itemtype="http://schema.org/Product">
                    <div class="ct_product_list">
                        <a class="product-list-link" href="<?php echo $product['href']; ?>">
                            <?php if ($category_id == NEW_YEAR_NABORS_CATEGORY) { ?>
                            <div class="gift-bant">
                                <img src="image/gift-bant.png" class="img-responsive" alt="Подарочная упаковка" />
                            </div>
                            <?php } ?>
                            <div class="pl_img text-center">
                                <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"
                                     title="<?php echo $product['name']; ?>"/>
                                <?php if ($product['showAnotherPhotoLabel']) { ?>
                                <br/>
                                <br/>
                                <small class="photo360 photo360-2">фото может отличаться от фактического изображения товара.</small>
                                <?php } ?>
                            </div>
                            <!--div class="category-product-icons col-md-1 hidden-sm hidden-xs">
                                <br/>
                                <?php if (empty($product['icons']) === false) { ?>
                                <?php foreach ($product['icons'] as $icon) { ?>
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <img src="image/product_icons/<?php echo $icon['image']; ?>" class="img-responsive" />
                                        </div>
                                        <div class="back">
                                            <div style="display: table-cell; height: 100%; vertical-align: middle">
                                                <?php echo $icon['text']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <?php } ?>
                            </div-->
                        </a>
                        <div class="caption">
                            <div class="box">
                                <a href="<?php echo $product['href']; ?>">
                                    <?php if ($product['showCommingSoonLabel']) { ?>
                                    <p class="control-label text-center">
                                        Скоро в продаже
                                    </p>
                                    <?php } elseif ($product['price']) { ?>
                                    <div class="ct_price_product_list pull-left" itemprop="offers" itemscope
                                         itemtype="http://schema.org/Offer">
                                        <?php if (!$product['special']) { ?>
                                            <?php if ($product['product_id'] == OMEGA1000_PRODUCT_FOR_ACTION) { ?>
                                                <span itemprop="price" class="price-new"><?php echo $product['price']; ?></span>
                                                <span class="price-old"><?php echo $product['price'] * 2; ?></span>
                                            <?php } else { ?>
                                                <span itemprop="price"><?php echo $product['price']; ?></span>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <span class="sale_rate"><?php
                                                $rate = round(100-($product['special']/($product['price']/100)));
                                                echo '-'.$rate.'%'; ?></span>
                                            <span itemprop="price" class="price-old"><?php echo $product['price']; ?></span>
                                            <span class="price-new"><?php echo $product['special']; ?></span>
                                            <small class="price-old"></small>
                                        <?php } ?>
                                            <span itemprop="priceCurrency" class="hidden">RUB</span>
                                    </div>
                                    <a href="<?php echo $product['href']; ?>">
                                        <h5 class="text-center" itemprop="name"><?php echo $product['name']; ?></h5> 
                                    </a>
                                    <?php } ?>
                                </a>
                            </div> <hr>
                                <?php if ($product['quantity'] > 0) { ?>
                                    <button class="quick_order"
                                            onclick="quick_order(
                                                <?php echo $product['product_id']; ?>,
                                                '<?php echo $product['name']; ?>',
                                                $('#qty_<?php echo $product["product_id"]; ?>').html()
                                                )">
                                        Заказать в один клик
                                    </button>
                                <?php } else {  ?>
                                <?php } ?>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="ct_count form-control">
                                        <table>
                                            <tr>
                                                <td><span class="minus_count">-</span></td>
                                                <td><span id="qty_<?php echo $product['product_id'];?>">1</span></td>
                                                <td><span class="plus_count">+</span></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <?php if ($product['quantity'] > 0) { ?>
                                        <button class="ct_add_to_cart"
                                                onclick="cart.add(<?php echo $product['product_id']; ?>, parseInt($('#qty_<?php echo $product['product_id']; ?>').html()))">
                                            <span>В корзину</span>
                                        </button>
                                    <?php } else { ?>
                                        <button class="ct_add_to_cart ct_add_to_predcart"
                                                onclick="quick_order(
                                                    <?php echo $product['product_id']; ?>,
                                                    '<?php echo $product['name']; ?>',
                                                    $('#qty_<?php echo $product["product_id"];?>').val());">
                                            <span >Предзаказ</span>                                   
                                        </button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if (($giftSetStatus) && (!$isOptBuyer)) { ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="gift-list-item">
                        <div class="caption">
                            <a href="<?php echo $createGiftSet; ?>">
                                <p class="text-center"><i class="fas fa-plus-circle"></i></p>
                                <p class="text-center">  Собрать подарочный набор</p>
                            </a>
                            <br/>
                            <div class="clearfix" style="height: 65px">
                                <a href="<?php echo $product['href']; ?>">
                                    <div class="ct_price_product_list pull-left">
                                        &nbsp;
                                    </div>
                                </a>
                            </div>
                            <br/>
                            <div class="clearfix">
                                <div class="pull-left">
                                    <br/>
                                </div>
                                <div class="pull-right">
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>

            <div id="content">
                <div class="textcontent text-justify">
                    <?php if ($share_button) { ?>
                    <br/>
                    <div class="row" id="share_button">
                        <div class="pull-right">
                            <label class="pull-right control-label">Поделиться</label><br/>
                            <div class="ya-share2" data-services="facebook,vkontakte,whatsapp,telegram"></div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php echo $description; ?>
                </div>
                <div class="video_bg"></div>
                <div class="video_play"></div>
                <?php echo $content_bottom; ?>
            </div>
        </div>
        <?php echo $column_right; ?>
    </div>
</div>
<?php echo $footer; ?>
