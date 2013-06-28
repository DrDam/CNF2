function init_raty()
{
    $('.fact').each(function() {

        var fact_id = $(this).attr('fact_id');

        $('#raty' + fact_id).raty({
            path: '/js/raty/img',
            cancel: true,
            number: 0,
            cancelHint: 'Ca va pas non !',
            click: function(score, evt) {

                var id = $(this).attr('id');
                var fact_id = id.replace('raty', '');

                var data = {action: 'choix', value: 0, fact: fact_id, type: 'txt'};
                cnf_ajax(data, '/ajax/valider.php', valider, fact_id);
            }
        });
    });
}

function valider(id, out)
{
    code = out.code;
    var msg = '';

    if (code == 1) // 1 => id inexistant
    {
        msg = '<strong class="red">Déjà supprimée</strong>';
    }
    if (code == 2) // 2 => mauvaise valeur de vote
    {
        msg = '<strong class="red">Hey coquinou on essaie de tricher ?</strong>';
    }
    if (code == 3) // 3 => ok pour suppression 
    {
        msg = '<strong class="red">Au goulag !</strong>';
    }

    $("#raty" + id).html(msg);
}

$(window).load(function() {

    init_raty();
});
