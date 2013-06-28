
function action(txt_sens, obj)
{
    var id = $(obj).attr('href');
    var sens = (txt_sens == 'out') ? 0 : 1;

    var data = {id: id, sens: sens};
    cnf_ajax(data, '/ajax/news.php', change, obj, true);

    return false;
}

function change(obj, sens)
{
    if (sens == 0)
    {
        var label = 'activer';
        var go = 'in';
        var del = 'out';
    }
    else
    {
        var label = 'desactiver';
        var go = 'out';
        var del = 'in';
    }
    $(obj).html(label);
    $(obj).removeClass(del).addClass(go);
}

function init_click()
{
    $('.link.out').click(function() {
        action('out', this);
        init_click();
        return false;
    });

    $('.link.in').click(function() {
        action('in', this);
        init_click();
        return false;
    });
}

$(window).load(function() {

    init_click();
});
