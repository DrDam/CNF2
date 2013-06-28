function init_raty()
{
    $('.fact').each(function() {

        var fact_id = $(this).attr('fact_id');

        $('#raty' + fact_id).raty({
            path: '/js/raty/img',
            number: 2,
            cancel: true,
            cancelHint: 'Ca va pas non !',
            hints: ['j\'me tate !', 'Elle est trop bien'],
            iconRange: [
                {range: 1, on: 'on.png', off: 'off.png'},
                {range: 2, on: 'star-on.png', off: 'star-off.png'},
            ],
            single: true,
            click: function(score, evt) {

                var action = (score == 1) ? 'hesit' : 'choix';

                var id = $(this).attr('id');
                var fact_id = id.replace('raty', '');

                var type = $(this).attr('type');

                if (!type)
                    type = 'txt';

                if (!score)
                    score = 0;

                if (score == 2)
                    score = 1;

                var data = {action: action, value: score, fact: fact_id, type: type};
                cnf_ajax(data, '/ajax/valider.php', valider, fact_id);
            }
        });
    });
}

function valider(id, out)
{
    var code = out.code;
    var msg = '';

    if (code == 0) // 0 => Ok pas de problème
    {
        msg = '<strong class="green">Accepté</strong>';
    }
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
    if (code == 4) // 4 => hésite 
    {
        msg = '<strong class="blue">Tu te tates encore</strong>';
    }
    if (code == 5) // 5 => doublo 
    {
        msg = '<strong class="blue">Doublon mis à jour</strong>';
    }
    $("#raty" + id).html(msg);
}

$(window).load(function() {

    init_raty()
});
