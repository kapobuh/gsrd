$(document).ready(function(){

    $('.psr_link').click(function () {
        var psr_id = $(this).attr("alt");
        $.ajax({
            url: '?route=common/search/getPsrInfo&token=<?php echo $token; ?>',
            type: 'get',
            data: 'psr_id=' + psr_id,
            beforeSend: function(){
                $('#psr_info_modal .modal-content .modal-body').html('Загрузка...');
                $('#psr_info_modal').modal();
            },
            success: function(html) {
                $('#psr_info_modal .modal-content').html(html);
            }
        })

    })

	psr = {
		'delete': function () {
            if (confirm('Вы действительно хотите удалить информацию о ПСР?')) {
                var psr_id = $(this).attr('data-psr-id');
                alert(psr_id);
                $.ajax({
                    url: '?route=common/psr/delete&psr_id=' + parseInt(psr_id) + '&token=' + token,
                    type: 'get',
                    beforeSend: function () {},
                    success: function (html) {

                    }
                });
			}

		},

        'getInfo': function () {

        }
	};
});