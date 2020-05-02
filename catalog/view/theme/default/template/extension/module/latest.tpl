<div class="container-sm">
    <div class="catalog_home">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <div class="catalog_title visible-md visible-lg">
                    <h3><a href="<?php echo $catalog_link; ?>">Каталог продукции</a></h3>
                    <p class="hidden-xs"><a href="<?php echo $catalog_link; ?>">Посмотреть все</a></p>
                </div>
                <div class="visible-xs visible-sm">
                    <h3><a href="<?php echo $catalog_link; ?>">Каталог продукции</a></h3>
                    <p class="hidden-xs"><a href="<?php echo $catalog_link; ?>">Посмотреть все</a></p>
                </div>
            </div>
            <div class="hidden-xs col-sm-4">
                <div class="catalog_title">
                    <h3><a href="<?php echo $nabors_link; ?>">Подарочные наборы NFO</a></h3>
                    <p class="hidden-xs"><a href="<?php echo $nabors_link; ?>">Посмотреть все</a></p>
                </div>
            </div>
        </div>

        <br class="hidden-xs"/>

        <div class="row">
            <div class="col-sm-6 col-md-8">
                <div class="row">
                    <?php foreach ($leftProducts as $product) {  ?>
                        <div class="col-sm-12 col-md-6">
                            <div class="ct_product_list latests">
                                <a href="<?php echo $product['href']; ?>">
                                    <div class="pl_img text-center">
                                        <img src="<?php echo $product['thumb']; ?>" alt=""/>
                                    </div>
                                </a>
                                <div class="caption">
                                    <div class="box">
                                        <div class="table-cell">
                                            <a href="<?php echo $product['href']; ?>">
                                                <div class="ct_price_product_list pull-left">
                                                    <?php if ($product['special']) { ?>
                                                        <span class="sale_rate">
                                                            <?php $rate = round(100-($product['special']/($product['price']/100)));
                                                                echo '-'.$rate.'%'; ?></span>
                                                        <span class="price-old"><?php echo $product['price']; ?></span>
                                                        <span class="price-new"><?php echo $product['special']; ?></span>
                                                        <small class="price-old"></small>
                                                    <?php
                                                    } else { ?>
                                                        <span><?php echo $product['price']; ?></span>
                                                    <?php } ?>
                                                </div>
                                                <h5 class="text-center"><?php echo $product['name']; ?></h5>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <button class="quick_order"
                                                    onclick="quick_order(
                                                        <?php echo $product['product_id']; ?>,
                                                        '<?php echo $product['name']; ?>',
                                                        $('#qty_<?php echo $product["product_id"]; ?>').html()
                                                        )">
                                                Заказать в один клик
                                    </button>
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
                </div>
            </div>
            <div class="col-xs-12 visible-xs">
                <br/>
                <br/>
                <p class="text-center"><a class="btn prim_btn prim_btn_cent" href="<?php echo $catalog_link; ?>">Посмотреть
                        все продукты</a></p>
                <hr/>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 no-side-padding">
                <?php foreach ($rightProducts as $product) {  ?>
                <div class="col-sm-12">
                    <div class="ct_product_list latests">
                        <a href="<?php echo $product['href']; ?>">
                            <div class="pl_img text-center">
                                <img src="<?php echo $product['thumb']; ?>" alt=""/>
                            </div>
                        </a>
                        <div class="caption">
                            <div class="box">
                                <div class="table-cell">
                                    <a href="<?php echo $product['href']; ?>">
                                        <div class="ct_price_product_list pull-left">
                                            <?php if ($product['special']) { ?>
                                                <span class="sale_rate">
                                                    <?php $rate = round(100-($product['special']/($product['price']/100)));
                                                        echo '-'.$rate.'%'; ?></span>
                                                <span class="price-old"><?php echo $product['price']; ?></span>
                                                <span class="price-new"><?php echo $product['special']; ?></span>
                                                <small class="price-old"></small>
                                            <?php
                                            } else { ?>
                                                <span><?php echo $product['price']; ?></span>
                                            <?php } ?>
                                        </div>
                                        <h5 class="text-center"><?php echo $product['name']; ?></h5>
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <button class="quick_order"
                                            onclick="quick_order(
                                                <?php echo $product['product_id']; ?>,
                                                '<?php echo $product['name']; ?>',
                                                $('#qty_<?php echo $product["product_id"]; ?>').html()
                                                )">
                                        Заказать в один клик
                            </button>
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
            </div>

            <!--div class="col-sm-4 no-side-padding">

                <div class="col-xs-12">
                    <div class="product_list latests">
                        <a href="<?php echo $gift_set_link; ?>">
                            <div class="gift-bant">
                                <img src="image/gift-bant.png" class="img-responsive" alt="Подарочная упаковка" />
                            </div>
                            <div class="pl_img text-center">
                                <img src="<?php echo $gift_set_image; ?>" alt=""/>
                            </div>
                        </a>
                        <div class="caption">
                            <a href="<?php echo $gift_set_link; ?>">
                                <h5 class="text-center"><i class="fas fa-plus-circle"></i><br/> Собрать подарочный набор</h5>
                                <hr/>
                            </a>

                            <div class="clearfix">
                                <br/>
                            </div>
                        </div>
                    </div>
                </div>

            </div-->

            <div class="col-xs-12 visible-xs">
                <br/>
                <br/>
                <p class="text-center"><a class="btn prim_btn prim_btn_cent" href="<?php echo $nabors_link; ?>">Посмотреть
                        все наборы</a></p>
                <hr/>
            </div>
        </div>

    </div>
</div>	