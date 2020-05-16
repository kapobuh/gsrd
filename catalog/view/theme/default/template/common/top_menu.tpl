<ul itemscope itemtype="http://schema.org/SiteNavigationElement" id="nav" class="list-unstyled">
    <li>
        <a itemprop="url" class="catalog_link" href="<?php echo $catalog; ?>">Каталог продукции <span class="caret"></span></a>
        <div class="dropmenu clearfix">
            <div class="pull-left">
                <ul>
                    <li><a itemprop="url" href="<?php echo $catalog; ?>">Вся продукция</a></li>
                    <li><a itemprop="url" href="<?php echo $omega3_nfo; ?>">Омега-3 NFO</a></li>
                    <li><a itemprop="url" href="<?php echo $vitamins; ?>">Витамины NFO</a></li>
                    <li><a itemprop="url" href="<?php echo $eco_balance; ?>">Эко-баланс</a></li>
                    <li><a itemprop="url" href="<?php echo $nabors; ?>">Наборы Омега-3 NFO </a></li>
                    <li><a itemprop="url" href="<?php echo $new_nabors; ?>">Подарочные наборы NFO</a></li>
                    <?php if ($gift_set) { ?>
                    <li><a itemprop="url" href="<?php echo $gift_set; ?>"><sup class="red-text">NEW </sup>Собрать подарочный набор</a></li>
                    <?php } ?>

                </ul>
            </div>
            <div class="pull-right">
                <ul>
                    <li><a itemprop="url" href="<?php echo $where_by; ?>">Где купить</a></li>
                    <li><a itemprop="url" href="<?php echo $delivery; ?>">Доставка и оплата</a></li>
                    <li><a itemprop="url" href="<?php echo $order; ?>">Как заказать</a></li>
                    <li><a itemprop="url" href="<?php echo $discounts; ?>">Система скидок</a></li>
                    <li><a itemprop="url" href="<?php echo $privacy; ?>">Пользовательское соглашение</a></li>
                </ul>
            </div>
            <br/>
        </div>
    </li>
    <li><a itemprop="url" href="<?php echo $sale; ?>">Акции <img src="image/percentage.svg" alt="Акции"/></a></li>
    <li><a itemprop="url" href="<?php echo $omega3articles; ?>">Омега-3</a>
        <div class="dropmenu clearfix">
            <div class="pull-left">
                <ul>
                    <li><a itemprop="url" href="<?php echo $omega3; ?>">Что такое омега-3 </a></li>
                    <li><a itemprop="url" href="<?php echo $omega3_history; ?>">История применения омега-3</a></li>
                    <li>
                        <hr/>
                    </li>
                    <li><a itemprop="url" href="<?php echo $useful; ?>">Для чего полезна омега-3? </a></li>
                    <li>
                        <small><a itemprop="url" href="<?php echo $pregnant; ?>"> Омега-3 для беременных </a></small>
                    </li>
                    <li>
                        <small><a itemprop="url" href="<?php echo $childs; ?>"> Омега-3 для детей</a></small>
                    </li>
                    <li>
                        <small><a itemprop="url" href="<?php echo $sportsman; ?>"> Омега-3 для спортсменов</a></small>
                    </li>
                </ul>
            </div>
            <br/>
        </div>
    </li>
    <li><a itemprop="url" href="<?php echo $for_experts; ?>">Специалистам</a>
        <div class="dropmenu clearfix">
            <div class="pull-left">
                <ul>
                    <li><a itemprop="url" href="<?php echo $articles; ?>">Статьи и публикации </a></li>
                    <li><a itemprop="url" href="<?php echo $clinical_research; ?>">Клинические исследования омега-3 </a></li>
                </ul>
            </div>
            <br/>
        </div>
    </li>
    <li><a itemprop="url" href="<?php echo $about; ?>">О компании</a>
        <div class="dropmenu clearfix">
            <div class="pull-left">
                <ul>
                    <li><a itemprop="url" href="<?php echo $about; ?>">История </a></li>
                    <li><a itemprop="url" href="<?php echo $news; ?>">Новости компании </a></li>
                    <li><a itemprop="url" href="<?php echo $quality; ?>">Контроль качества </a></li>
                    <li><a itemprop="url" href="<?php echo $awards; ?>">Награды и достижения </a></li>
                    <li><a itemprop="url" href="<?php echo $carer; ?>">Карьера</a></li>
                    <li><a itemprop="url" href="<?php echo $cooperation; ?>">Сотрудничество</a></li>
                </ul>
            </div>
            <br/>
        </div>
    </li>
    <li><a itemprop="url" href="<?php echo $partners; ?>">Партнёры</a></li>
    <li><a itemprop="url" href="<?php echo $video; ?>">Видео</a></li>
    <li><a itemprop="url" href="<?php echo $faq; ?>">Вопрос - ответ</a></li>
    <li><a itemprop="url" href="<?php echo $contacts; ?>">Контакты</a></li>
</ul>