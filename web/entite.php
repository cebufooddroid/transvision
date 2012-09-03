<?php

if (!$valid) die;

include '../PAGES/function_clean.php';

# Find the current directory and the locale short name
$locale = strip_tags(preg_replace("/\/glossaire\/(.*)\/entite.php/", "$1", $_SERVER['REQUEST_URI']));
#$locale1=strip_tags(preg_replace("/\/*index.php.*/","",$_SERVER['REQUEST_URI']));
#$locale2=strip_tags(preg_replace("/\/glossaire\/(.*)/","$1",$locale1));
#$locale=strip_tags(preg_replace("/(.*)\//","$1",$locale2));

## Deduce the memoire.tmx directory name
$tmxfile = TMX . '/memoire_en-US-' . $locale . '.tmx';

clearstatcache();

include TMX . '/cache/' . $locale . '/cache_' . $locale . '.php'; // localised
$tmx_target = $tmx;

include TMX . '/cache/' . $locale . '/cache_en-US.php'; // english
$tmx_source = $tmx;

// get language arrays
$tmx_source = $tmx_source;
$tmx_target = $tmx_target;


echo "<"."?"."xml version=\"1.0\" encoding=\"UTF-8\""."?".">\n";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"fr\" lang=\"fr\" dir=\"ltr\">\n\n";
echo "<head>\n";
echo "  <title>Entity search</title>\n";
echo "  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
echo "  <link rel=\"stylesheet\" href=\"../styles/glossary.css\" type=\"text/css\" media=\"all\" />\n";
echo "</head>\n\n";
echo "<body>\n\n";
echo "  <h1>Search for entities</h1>\n\n";
echo "<script type=\"text/javascript\" src=\"../PAGES/wz_tooltip.js\"></script>\n";


/*echo "<h2>English :</h2>\n";
// list keys and values
echo "<ul>\n";
while (list($key, $val) = each($tmx_source)) {
    echo "<li>\$tmx-&gt;resource['".$key."'] = ".$val."</li>\n";
}
echo "</ul>\n";

echo "<h2>Français :</h2>\n";
echo "<h2>French:</h2>\n";
// list keys and values
echo "<ul>";
while (list($key, $val) = each($tmx_target)) {
    echo "<li>\$tmx-&gt;resource['".$key."'] = ".$val."</li>\n";
}
echo "</ul>\n";
*/

$initial_search = $recherche;

//$recherche=$_GET['recherche'];
if (isset($_GET['recherche'])) {
    $recherche = stripslashes(secureText($_GET['recherche']));
}

$initial_search = $recherche;
$recherche  = preg_quote($recherche);
$recherche  = sql_regcase("*" . $recherche . "*");

$keys  = preg_grep(sql_regcase("/\&.*;/"), $tmx_source);
$keys2 = preg_grep(sql_regcase("/\&.*;/"), $tmx_target);


//$keys = preg_grep($recherche, l_en);
//$keys2 = preg_grep($recherche, $tmx_target);
echo "  <h2>" . $sourceLocale . " entity list</h2>\n\n";
echo "  <table>\n\n";
echo "    <tr>\n";
echo "      <th>Entity</th>\n";
echo "      <th>" . $sourceLocale . "</th>\n";
echo "      <th>" . $locale . "</th>\n";
echo "    </tr>\n\n";

foreach ($keys as $key=>$chaine) {
    $aaa=strip_tags(preg_replace("/.*(\&.*;).*/","$1",$chaine));
    $bbb=strip_tags(preg_replace("/.*(\&.*;).*/","$1",$tmx_target[$key]));
    #echo "      <td>".strip_tags(preg_replace("/.*(\&.*;).*/","$1",$chaine))."</td>\n";
    #echo "      <td>".strip_tags(preg_replace("/.*(\&.*;).*/","$1",$tmx_target[$key]))."</td>\n";
    #echo "    </tr>\n\n";
    if ($aaa == $bbb) {
        #echo "      <td>".$key."</td>\n";
        #echo "      <td><a  href=\"javascript:void(0);\" onmouseover=\"Tip('.".$chaine."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\">".htmlspecialchars($aaa)."</a></td>\n";
        #echo "      <td><a  href=\"javascript:void(0);\" onmouseover=\"Tip('.".$tmx_target[$key]."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\">".htmlspecialchars($bbb)."</a></td>\n";
        #echo "    </tr>\n\n";
    } else {
        echo "    <tr>\n";
        echo "      <td>".$key."</td>\n";
        echo "      <td><a href=\"javascript:void(0);\" onmouseover=\"Tip('.".htmlspecialchars($chaine)."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\" class=\"entities\">".htmlspecialchars($aaa)."</a></td>\n";
        echo "      <td><a href=\"javascript:void(0);\" onmouseover=\"Tip('.".htmlspecialchars($tmx_target[$key])."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\" class=\"entities\">".htmlspecialchars($bbb)."</a></td>\n";
        echo "    </tr>\n\n";
    }
}

echo "  </table>\n\n";
echo "  <h2>".$locale." entity list</h2>\n\n";
echo "  <table>\n\n";
echo "    <tr>\n";
echo "      <th>Entity</th>\n";
echo "      <th>" . $sourceLocale . "</th>\n";
echo "      <th>" . $locale . "</th>\n";
echo "    </tr>\n\n";

foreach ($keys2 as $key => $chaine) {
    $bbb = strip_tags(preg_replace("/.*(\&.*;).*/", "$1", $chaine));
    $aaa = strip_tags(preg_replace("/.*(\&.*;).*/", "$1", $tmx_source[$key]));
    #echo "      <td>".strip_tags(preg_replace("/.*(\&.*;).*/","$1",$tmx_source[$key]))."</td>\n";
    #echo "      <td>".strip_tags(preg_replace("/.*(\&.*;).*/","$1",$chaine))."</td>\n";
    #echo "    </tr>\n\n";

    if ($aaa == $bbb) {
    #echo "      <td>".$key."</td>\n";
    #echo "      <td><a  href=\"javascript:void(0);\" onmouseover=\"Tip('.".$tmx_source[$key]."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\">".htmlspecialchars($aaa)."</a></td>\n";
    #echo "      <td><a  href=\"javascript:void(0);\" onmouseover=\"Tip('.".$chaine."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\">".htmlspecialchars($bbb)."</a></td>\n";
    #echo "    </tr>\n\n";
    } else {
        echo "    <tr>\n";
        echo "      <td>".$key."</td>\n";
        echo "      <td><a href=\"javascript:void(0);\" onmouseover=\"Tip('.".htmlspecialchars($tmx_source[$key])."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\" class=\"entities\">".htmlspecialchars($aaa)."</a></td>\n";
        echo "      <td><a href=\"javascript:void(0);\" onmouseover=\"Tip('.".htmlspecialchars($chaine)."', CLICKSTICKY, true);\" onmouseout=\"UnTip()\" class=\"entities\">".htmlspecialchars($bbb)."</a></td>\n";
        echo "    </tr>\n\n";
    }
}
echo "  </table>\n\n";
//print_r($keys);
//echo  $tmx_source($key) . "<br />";
echo "  <div id=\"links\">\n";
echo "    <ul>\n";
echo "      <li><a href=\"index.php\" title=\"Search in the Glossary\">Glossary</a></li>\n";
echo "      <li><a href=\"alignement.php\" title=\"Search for similarities\">Alignment</a></li>\n";
echo "      <li><a href=\"doublons.php\" title=\"Search for Duplicates\">Duplicates</a></li>\n";
echo "      <li><a href=\"entite.php\" title=\"Search for Entities\">Entities</a></li>\n";
echo "      <li><a href=\"http://www.frenchmozilla.fr\" title=\"Home of Frenchmozilla\"
hreflang=\"fr\">Frenchmozilla</a></li>\n";
echo "    </ul>\n";
echo "  </div>\n\n";

echo "</body></html>";
