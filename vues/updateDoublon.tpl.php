<form method='POST' id='update' name='update' >
    <?php print Forms::label('Restart all doublons', 'reset') ?>
    <input id="perm" value="reset" type="checkbox" name="reset" />
    <br/>

<?php if (isset($doubles)): ?>
        <table>
            <caption>La fact est-elle un doublon ?</caption>
            <tr>
                <th>Fact suspect</th>
                <th>Réference Possible</th>
                <th>Conformitée *</th>
                <th>Doublon</th>
            </tr>
            <?php foreach ($doubles as $key => $double): ?>
                <tr>
                    <td>
                        <?php print $key.'=>'.$double['new'] ; ?>
                    </td>
                    <td>
                        <?php print $double['ref'].'=>'.$double['old']; ?>
                    </td>
                    <td>
                        <?php print $double['data']; ?>
                    </td>
                    <td>
                        <input id="fact_<?php print $double['ref'] ?>" type="checkbox" name="perm[<?php print $key ?>]" value="<?php print $double['ref'] ?>"/>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php
 endif ?>
<br />
<input type="submit" name="valider" value="updateDoublon" />

</form>


L'indice de coformité est un rapport de comparaison de la forme x-y-z
<ul><li>
    Le premier chiffre correspond au nombre d'élements testé dans la fact.
    </li><li> 
     Le Second chiffre correspond au nombre d'élements testé dans la référence.
    </li><li>
     Le troisieme chiffre correspond au nombre de d'élements commun.
</li></ul>
les mot "chuck" et "norris" ne sont pas testé comme les mot de moins de 2 caractères
