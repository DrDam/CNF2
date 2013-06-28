function moderation(id, out)
{
    code = out.code;
    var msg = '';

    if (code == 0) // 0 => Ok pas de problème
    { 
        msg = '<strong class="green">Merci</strong>';
        $('#points' + id + ' span.1').html(out.moyenne + ' %');
        $('#points' + id + ' span.2').html(out.votes);
    }
    if (code == 1) // 1 => id inexistant
    {

    }
    if (code == 2) // 2 => mauvaise valeur de vote
    {
        msg = '<strong class="red">Hey coquinou on essaie de tricher ?</strong>';
    }

    $("#raty" + id).html(msg);
}

function init_raty()
{

    $('.fact').each(function() {

        var fact_id = $(this).attr('fact_id');

        $('#raty' + fact_id).raty({
            path: '/js/raty/img',
            number: 1,
            cancel: true,
            cancelHint: 'Ca va pas non !',
            hints: ['Elle est trop bien'],
            click: function(score, evt) {
                var id = $(this).attr('id');
                var fact_id = id.replace('raty', '');

                var type = $(this).attr('type');
                if (!type)
                    type = 'txt';

                if (!score)
                    score = 0;

                var data = {choix: score, fact: fact_id, type: type};
                cnf_ajax(data, '/ajax/moderation.php', moderation, fact_id);

            }
        });
    });
}

$(window).load(function() {

    init_raty()

});
