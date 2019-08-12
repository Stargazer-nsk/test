// Все "переходы" осуществляются с помощью ajax.
jQuery(document).ready( function ($) {
    onClick();
    $(document).ajaxSuccess( function () {
        onClick();
    });
});

function onClick() {
    $('.go_to').click( function () {
        let data = $(this).data('ajax');
        let parent = $(this).data('parent');
        $.ajax({
            type: 'POST',
            dataType: 'html',
            data: {
                data: data,
                parent: parent
            },
            url: './index.php',
            success: function(data){
                $('.main').html(data);
            }
        });
    });
}