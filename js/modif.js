$(window).load(function() {

    $('.fact').each(function() {

        var fact_id = $(this).attr('fact_id');
        $('a#modif' + fact_id).click(function() {

            var data = {fact: fact_id};
            cnf_ajax(data, '/ajax/modif1.php', modif, fact_id, true);
            return false;
        });
    });

    function modif(fact_id, form)
    {
        $('#fact' + fact_id + ' .factbody').html(form);

        $('form#modif').submit(function() {

            var fact_txt = $('#factmodif' + fact_id).val();

            var data2 = {fact: fact_id, fact_txt: fact_txt};
            cnf_ajax(data2, '/ajax/modif2.php', modif2, fact_id, true);

            return false;
        });
    }


    function modif2(fact_id, factbody)
    {
        $('#fact' + fact_id + ' .factbody').html(factbody);

        init_raty();
    }

});
