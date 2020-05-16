<?php echo $header; ?>
<div class="bread-box container">
    <div class="bread fullclass">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php if ($breadcrumb['href']) { ?>
        <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a> →
        <?php } else { ?>
        <a class="current"><?php echo $breadcrumb['text']; ?> ↓</a>
        <?php } ?>
        <?php } ?>
    </div>
</div>
<div class="container-fluid page_title_bg">
    <div class="container textcontent">
        <h1 class="text-center"><?php echo $heading_title; ?></h1>
    </div>
</div>

<div class="container">

    <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-7'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>

        <div id="content-transp" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <div id="product" class="row product_top" itemscope itemtype="http://schema.org/Product">
                <meta itemprop="name" content="<?php echo $heading_title; ?>">
                <div class="col-sm-5 col-md-5">


                    <div class="visible-xs ct_price_product_list pull-left">
                        <?php if ($showCommingSoonLabel) { ?>
                        <p class="control-label text-center">
                            Скоро в продаже
                        </p>
                        <?php } elseif ($price) { ?>
                        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                            <div class="price mod">

                                <?php if ($upc) { ?>
                                <div class="price-new-temp"><?php echo $upc; ?> ₽</div>
                                <?php } ?>
                                <p class="price">
                                    <?php if (!$special) { ?>

                                    <span class="only-price" itemprop="price"><?php echo $price; ?></span>
                                    <?php } else { ?>
                                    
                                    <span class="sale_rate"><?php
                                            $rate = round(100-($special/($price/100)));
                                            echo '-'.$rate.'%'; ?>
                                    </span>
                                    <span class="price-old"><?php echo $price; ?></span>
                                    <span itemprop="price" class="price-new"><?php echo $special; ?></span>
                                    <?php } ?>
                                    <?php if ($tax) { ?>
                                    <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
                                    <?php } ?>
                                    <span class="hidden" itemprop="priceCurrency">RUB</span>
                                </p>
                            </div>
                        </div>
                        <?php } ?>
                    </div>



                    <div class="product_image clearfix">
                        <div class="images-list-div">
                            <div class="clearfix">
                                <?php if ($thumb || $images) { ?>
                                <?php if ($images) { ?>
                                <ul id="images-list" class="thumbnails list-unstyled">
                                    <?php foreach ($images as $image) { ?>
                                    <li class="image-additional"><a class="fancybox"
                                                                    rel="group_2"
                                                                    href="<?php echo $image['popup']; ?>">
                                            <img
                                                    src="<?php echo $image['thumb']; ?>"
                                                    title="<?php echo $heading_title; ?>"
                                                    alt="<?php echo $heading_title; ?>"/></a></li>
                                    <li><br/></li>
                                    <?php } ?>
                                </ul>
                                <?php } } ?>
                            </div>
                        </div>
                        <div class="thumb">
                            <a href="<?php echo $popup; ?>" class="fancybox" rel="group_2"><img src="<?php echo $thumb; ?>"
                                                                                  title="<?php echo $heading_title; ?>"
                                                                                  alt="<?php echo $heading_title; ?>"
                                                                                  class="img-responsive"/></a>
                        </div>
                        <?php if ($showAnotherPhotoLabel) { ?>
                            <div class="col-xs-12">
                                <p class="control-label">Обратите внимание, фотография на сайте может отличаться от фактического изображения товара.</p>
                            </div>
                        <?php } elseif (in_array($product_id, $gift_sets)) { ?>
                            <div class="col-xs-12">
                                <p class="control-label">Оформление набора на фотографиях может отличаться от фактической упаковки товара.</p>
                            </div>
                        <?php } elseif (($product_id == ECO_BALANCE_HIGN_SET) || ($product_id == ECO_BALANCE_SET) || ($product_id == ECO_BALANCE_MEDIUM_SET)) { ?>
                        <div class="col-xs-12">
                            <p class="control-label">Набор не комплектуется в подарочную упаковку</p>
                        </div>
                        <?php } ?>
                    </div>
                    
                </div>
<!--                 <div class="product-icons col-md-1 hidden-sm hidden-xs">
                    <br/>
                    <?php if (empty($icons) === false) { ?>
                    <?php foreach ($icons as $icon) { ?>
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
                </div> -->

                <?php if ($product_id == GENTLEIRON_PRODUCT) { ?>
                <div class="col-sm-2 col-md-1 hidden-xs">
                    <div class="expiration-date-warning" data-toggle="tooltip" data-original-title="Ограниченный срок годности">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                </div>
                <?php } ?>

                <div class="col-sm-5 col-md-4">
                    <!--br class="visible-xs"/>
                    <br class="visible-xs"/-->
                    <div class="caption product_left">                        

                        <div class="clearfix">
                            <div class="hidden-xs ct_price_product_list pull-left">
                                <?php if ($showCommingSoonLabel) { ?>
                                <p class="control-label text-center">
                                    Скоро в продаже
                                </p>
                                <?php } elseif ($price) { ?>
                                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                    <div class="price mod">

                                        <?php if ($upc) { ?>
                                        <div class="price-new-temp"><?php echo $upc; ?> ₽</div>
                                        <?php } ?>
                                        <p class="price">
                                            <?php if (!$special) { ?>

                                            <span itemprop="price" class="only-price"><?php echo $price; ?></span>
                                            <?php } else { ?>
                                            
                                            <span class="sale_rate"><?php
                                                    $rate = round(100-($special/($price/100)));
                                                    echo '-'.$rate.'%'; ?>
                                            </span>
                                            <span class="price-old"><?php echo $price; ?></span>
                                            <span itemprop="price" class="price-new"><?php echo $special; ?></span>
                                            <?php } ?>
                                            <?php if ($tax) { ?>
                                            <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span>
                                            <?php } ?>
                                            <meta itemprop="priceCurrency" content="RUB">
                                        </p>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="clearfix">
                                <div class="pull-left">
                                    <div class="ct_count form-control">
                                        <table>
                                            <tr>
                                                <td><span class="minus_count">-</span></td>
                                                <td><span id="ct_count_val">1</span></td>
                                                <td><span class="plus_count">+</span></td>
                                            </tr>
                                        </table>
                                        <input value="<?php echo $product_id; ?>" name="product_id" id="product_id"
                                               type="hidden">
                                        <input value="1" name="quantity" id="quantity" type="hidden">
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <?php if ($quantity > 0) { ?>
                                    <button class="ct_add_to_cart" id="button-cart">
                                        <span>В корзину</span>
                                    </button>
                                    <?php } else { ?>
                                    <button class="quick_order"
                                            onclick="quick_order(<?php echo $product_id; ?>, '<?php echo $heading_title; ?>')">
                                        <span>Предзаказ</span>
                                    </button>
                                    <?php } ?>
                                </div>
                            </div>

                            
                            <?php if ($quantity > 0) { ?>
                            <button class="quick_order"
                                    onclick="quick_order(
                                                <?php echo $product_id; ?>,
                                                '<?php echo $heading_title; ?>',
                                                $('#ct_count_val').html())">
                                Заказать в один клик
                            </button>
                            <?php } ?>
                            
                        </div>

                        <div class="m-order-2">
                            <?php if ($jan) { ?>
                                <label class="control-label">Форма выпуска</label>
                                <p><?php echo $jan; ?></p>
                            <?php } ?>
                            <br/>

                            <?php if (!empty($expirationDate)) { ?>
                                <label class="control-label">Срок годности</label>
                            <p><span class="red-text"><?php echo $expirationDate; ?></span> (осталось <?php echo $expirationDays; ?> дн.)</p>
                            <br/>
                            <?php } ?>

                            <?php if (isset($sets[$product_id])) { ?>
                                <label class="control-label">Состав набора</label>
                                <ul class="product_nabors_list">
                                    <?php foreach ($sets[$product_id] as $nabor_item) { ?>
                                    <li><?php echo $nabor_item; ?></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>

                            <?php if ($ean) { ?>
                                <label class="control-label">Способ применения</label>
                                <div><?php echo $ean; ?></div>
                            <?php } ?>
                        </div>
                        

                        </div>
                </div>
                
                <div class="col-sm-5 col-md-3 m-order-1">
                    <div class="product-delivery">
                        <h3>Доставка</h3>
                        <div class="current-city">
                            <span class="city-label">В Москву</span>
                        </div>
                        <div class="set-city-link"><a href="#">Изменить</a>
                        </div>
                        <div class="delivery-method">
                            <div class="courier">
                               <img src="catalog/view/theme/default/img/courier.png">
                               <span>Курьер до двери</span>
                               <span class="delivery-period">1дн. 300 руб.</span>
                            </div>
                            <div class="boxberry">
                               <img src="catalog/view/theme/default/img/boxberry.png">
                               <span>Самовывоз (ПВЗ Boxberry)</span>
                               <span class="delivery-period">1дн. 170 руб.</span>
                            </div>
                            <div class="post-office">
                               <img src="catalog/view/theme/default/img/post.png">
                               <span>С наложенным платежом</span>
                               <span class="delivery-period">5дн. 350 руб.</span>
                            </div>
                        </div>
                        <div class="payment-method">
                            <img src="catalog/view/theme/default/img/visa.png">
                            <img src="catalog/view/theme/default/img/mastercard.png">
                            <img src="catalog/view/theme/default/img/mir.png">
                            <img src="catalog/view/theme/default/img/android-pay.png">
                            <img src="catalog/view/theme/default/img/itunes.png">
                            <img src="catalog/view/theme/default/img/yamoney.png">
                            <img src="catalog/view/theme/default/img/qiwi.png">
                        </div>
                    </div>
                </div>


            </div>

            <br/>
			<br/>

        </div>
    </div>
</div>

<br/>
<div class="container-fluid product_submenu_line">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div class="product_submenu">
                    <a data-content="product_description" class="text-center ps_active">Описание</a>
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="product_submenu">
                    <a data-content="product_reviews" class="text-center">Отзывы</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
fbq('track', 'ViewContent', {
value: <?php  if (!$special) {$pricenocurrency = $price; }else{$pricenocurrency = $special;}     $pricenocurrency  = preg_replace( '/\D/', '', $pricenocurrency ); echo $pricenocurrency ;?>,
currency: 'RUR',
content_ids: <?php echo $product_id; ?>,
content_type: "<?php echo $category_name; ?>",
});


let prod_prc = <?php  if (!$special) {$pricenocurrency = $price; }else{$pricenocurrency = $special;}     $pricenocurrency  = preg_replace( '/\D/', '', $pricenocurrency ); echo $pricenocurrency ;?>; 
let cont_id = <?php echo $product_id; ?>; 
let cont_type = "<?php echo $category_name; ?>"; 
</script>

<script>
$(document).ready(function(){
	$('#button-cart').click(function(){
		
		fbq('track', 'AddToCart', {
			value: parseInt($('#ct_count_val').html()) * prod_prc,
			currency: 'RUR',
			contents: [
			{
			id: cont_id,
			quantity: parseInt($('#ct_count_val').html())
			}
			],
			content_ids: cont_id,
			content_type: cont_type,
		});

	
	})


})

</script>


<div class="container">
    <div class="row">
        <div>
            <br/>
            <div itemprop="description">
                <div class="col-xs-12 product-description text-justify">
                    <div class="tab-content">

                        <!-- <?php if (empty($icons) === false) { ?>
                        <div class="row product-icons-mobile visible-xs visible-sm">
                            <?php foreach ($icons as $icon) { ?>
                            <div class="product-icon-mobile clearfix col-xs-12 col-sm-6">
                                <div class="image">
                                    <img src="image/product_icons/<?php echo $icon['image']; ?>" class="img-responsive" />
                                </div>
                                <div class="text"><?php echo $icon['text']; ?></div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?> -->

                        <div id="product_description" class="product_content active"><?php echo $description; ?></div>

                        <?php if ($review_status) { ?>
                        <div id="product_reviews" class="product_content">
                            <form class="form-horizontal" id="form-review">
                                <div id="review"></div>
                                <div class="product_reviews_form">
                                    <h2><?php echo $text_write; ?></h2>
                                    <?php if ($review_guest) { ?>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label"
                                                   for="input-name"><?php echo $entry_name; ?></label>
                                            <input type="text" name="name" value="<?php echo $customer_name; ?>"
                                                   id="input-name" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-sm-12">
                                            <label class="control-label"
                                                   for="input-review"><?php echo $entry_review; ?></label>
                                            <textarea name="text" rows="5" id="input-review"
                                                      class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group required">
                                        <div class="col-sm-12 hidden">
                                            <label class="control-label"><?php echo $entry_rating; ?></label>
                                            &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                                            <input type="radio" name="rating" value="1"/>
                                            &nbsp;
                                            <input type="radio" name="rating" value="2"/>
                                            &nbsp;
                                            <input type="radio" name="rating" value="3"/>
                                            &nbsp;
                                            <input type="radio" name="rating" value="4"/>
                                            &nbsp;
                                            <input type="radio" name="rating" value="5" checked="checked"/>
                                            &nbsp;<?php echo $entry_good; ?></div>
                                    </div>
                                    <div class="buttons clearfix">
                                        <div class="pull-left">
                                            <button type="button" id="button-review"
                                                    data-loading-text="Подождите"
                                                    class="prim_btn">Отправить отзыв</button>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                    <?php echo $text_login; ?>
                                    <?php } ?>
                                </div
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Shema -->
            <br/>
            <br/>

            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>