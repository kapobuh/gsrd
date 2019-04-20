$(document).ready(function(){

    var admin_token = $('#admin-token').val();

    /**
     * Поиск результатов
     */
    $("#search_btn").click(function(){
        if (($('input[name="date_start"]').val().length < 8) || ( ($('input[name="date_end"]')).val().length < 8)) {
            $('#results .content').html('<br/><p class="text_empty text-center">Неверно указан период.</p>');
            $('.text_empty').fadeIn('');
        } else {
            $.ajax({
                url:  '?route=common/search/getResults&token=' + admin_token,
                type: 'post',
                data: $('input[type="text"], input[type="checkbox"]:checked'),
                beforeSend: function () {
                    $('#results .content').html('<p class="text-center">Идет поиск...</p><p style="margin-top:-20px;" class="text-center"><img style="width:80px;" src="view/image/loading.gif" alt=""/></p>');
                },
                success: function(html) {
                    $('#results .content').html(html);
                }
            })
        }
    });



	psr = {
		'delete': function (psr_id) {
            if (confirm('Вы действительно хотите удалить информацию о ПСР?')) {
                $.ajax({
                    url: '?route=common/psr/delete&psr_id=' + parseInt(psr_id) + '&token=' + admin_token,
                    type: 'get',
                    beforeSend: function () {},
                    success: function (html) {
                        $('#psr_info_modal').modal('hide');
                        $('#psr-item-' + psr_id).remove();
                    }
                });
			}

		},

        'edit': function (psr_id) {
            window.open('index.php?route=common/psr/edit&token=' + admin_token + '&psr_id=' + psr_id);
        }
	};
});