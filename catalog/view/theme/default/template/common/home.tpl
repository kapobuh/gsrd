<?php echo $header; ?>

<?php echo $slideshow_module; ?>
<div class="container">
<div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-7'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>

	</div>
    <?php echo $column_right; ?></div>
</div>

<?php echo $experts_reviews_module; ?>

<div class="container">
<div class="row">
    <div id="content2" class="<?php echo $class; ?>">
        <?php echo $content_bottom; ?>
    </div>
    </div>
</div>

<?php echo $footer; ?>