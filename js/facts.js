function voteOk(id, out)
{
    code = out.code;
    var msg = '';
    if (code == 0) // 0 => Ok pas de problème
    {
        msg = '<strong class="green">A voté</strong>';
        $('#points' + id).html(out.moyenne + ' / 10');
    }
    if (code == 1) // 1 => id inexistant
    {
    }
    if (code == 2) // 2 => mauvaise valeur de vote
    {
        msg = '<strong class="red">Hey coquinou on essaie de tricher ?</strong>';
    }
    if (code == 3) // 3 => type faux
    {
    }

    if (code == 4) // 4 => déjà voté
    {
        msg = '<strong class="red">Déjà voté</strong>';
    }

    $("#raty" + id).html(msg);
}

function init_raty()
{
    $('.fact').each(function() {

        var fact_id = $(this).attr('fact_id');

        $('#raty' + fact_id).raty({
            path: '/js/raty/img',
            cancel: true,
            score: function() {
                return $(this).attr('data-score');
            },
            cancelHint: 'Berk !!',
            hints: ['pour l\'effort', 'pas mal', 'sympa', 'du grand Chuck Norris', 'Chuck, tu rocks !'],
            click: function(score, evt) {
                var id = $(this).attr('id');
                var fact_id = id.replace('raty', '');

                var type = $(this).attr('type');
                if (!type)
                    type = 'txt';

                if (!score)
                    score = 0;

                var data = {vote: score, fact: fact_id, type: type};
                cnf_ajax(data, '/ajax/vote.php', voteOk, fact_id);
            }
        });
    });
}

$(window).load(function() {

    init_raty();

});
