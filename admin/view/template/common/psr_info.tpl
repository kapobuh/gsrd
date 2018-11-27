<p><b>Населенный пункт:</b> <?php echo $locality; ?></p>
<p><b>Вид ЧС:</b> <?php echo $type; ?></p>

<p><b>Привлеченная техника:</b></p>
<ul>
    <?php foreach ($result_technic as $t) { ?>
    <li><?php echo $t['name']; ?> <?php echo $t['quantity']; ?></li>
    <?php } ?>
</ul>

<?php if ($result_equipment) { ?>
<p><b>Использованное оборудование:</b></p>
<ul>
    <?php foreach ($result_equipment as $e) { ?>
    <li><?php echo $e['name']; ?> </li>
    <?php } ?>
</ul>
<?php } ?>

<h4><b>Участники ПСР:</b></h4>
<ul>
    <?php foreach ($participants as $p) { ?>
    <li><?php echo $p['t']; ?> <?php echo $p['q']; ?></li>
    <?php } ?>
</ul>

<?php if ($injureds) { ?>
<h4><b>Пострадавшие</b></h4>
<ul>
    <?php foreach ($injureds as $i) { ?>
    <li><?php echo $i['save_type']. ' ' . $i['lastname']. ' ' .$i['firstname'] . " (" . $i['birthday'] . ")"; ?></li>
    <?php } ?>
</ul>
<?php } else { ?>
<p>Пострадавших нет</p>
<?php } ?>
<br/>
<h4><b>Описание ПСР</b></h4>
<div class="well">
    <?php echo $description; ?>
</div>

<script>
    $(document).ready(function(){
        $('#psr_info_modal .modal-content .modal-header h3').html('<?php echo $heading_title; ?>');
    });
</script>