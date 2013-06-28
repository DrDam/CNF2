$(window).ready(function() {
    $('textarea.tinymce').tinymce({
        // Location of TinyMCE script
        script_url: '/js/tiny_mce/tiny_mce.js',
        // General options
        theme: "advanced",
        plugins: "ccSimpleUploader,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
        // Theme options
        theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        theme_advanced_styles: 'Link to Image=lightbox',
        // Example content CSS (should be your site CSS)
        content_css: "css/content.css",
        relative_urls: false,
        file_browser_callback: "ccSimpleUploader",
        plugin_ccSimpleUploader_upload_path: '../../../../img',
        plugin_ccSimpleUploader_upload_substitute_path: '/img/',
        // Replace values for the template plugin
        template_replace_values: {
            username: "Some User",
            staffid: "991234",
        }



    });

});
