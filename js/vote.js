function cnf_ajax(data, url, callback, var_to_callback, no_json)
{
    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        success: function(string) {
            var out = (no_json == true) ? string : jQuery.parseJSON(string);
            callback(var_to_callback, out);
        }
    });
}

