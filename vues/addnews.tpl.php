<form method="post" name='news' action="/addnews">
    <?php if (isset($news)): ?>
        <input type='hidden' name='newsId' value='<?php print $news->id ?>' />
    <?php endif ?>
    <?php print Forms::label('Titre de l\'article', 'title'); ?>
    <input type='text' name='title' 
           value='<?php if (isset($news)) print $news->titre ?>'
           />

    <br />

    <?php print Forms::label('Alias d\'url', 'slug'); ?>
    <input type='text' name='slug' 
           value='<?php if (isset($news)) print $news->slug ?>'
           />
    <textarea id="news" name="news" rows="15" cols="80" style="width: 80%" class="tinymce">
        <?php if (isset($news)) print $news->news ?></textarea>
    <input type="submit" name="save" value="Submit" />
    <input type="reset" name="reset" value="Reset" />
</form>
