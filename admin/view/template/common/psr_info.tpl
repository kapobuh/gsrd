<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h3 class="modal-title" id="myModalLabel"></h3>
</div>
<div class="modal-body">

    <h3><?php echo $locality; ?>, <?php echo $address; ?></h3>
    <p><b>Период проведения работ: </b> <?php echo $date; ?></p>

    <?php if (isset($PeopleHoursWorks)) { ?>
        <p><b>Ч.ЧВСОВ:</b> <?php echo $PeopleHoursWorks; ?></p>
    <?php } ?>
    <hr/>

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
            <li><?php echo $i['save_type']. ' ' . $i['lastname']. ' ' .$i['firstname'] . " (" . $i['birthday'] . " г. р.)"; ?></li>
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

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть окно</button>
    <button onclick="psr.edit(<?php echo $psr_id; ?>)" type="button" class="btn btn-primary" data-dismiss="modal">Редактировать</button>
    <button onclick="psr.delete(<?php echo $psr_id; ?>)" type="button" class="btn btn-danger">Удалить информацию о ПСР
    </button>
</div>

<script>
    $(document).ready(function () {
        $('#psr_info_modal .modal-content .modal-header h3').html('<?php echo $heading_title; ?>');
    });
</script>