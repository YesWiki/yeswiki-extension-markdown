<?php
/**
 * Passer les pages de wakka a markdown
 */

if ($this->userIsAdmin()) {
    // recuperation des pages wikis
    $sql = 'SELECT DISTINCT tag,body FROM ' . $this->GetConfigValue('table_prefix') . 'pages';
    $sql .= ' WHERE latest="Y" AND tag NOT LIKE "LogDesActionsAdministratives%" ';
    $sql .= ' AND tag NOT IN (SELECT resource FROM ' . $this->GetConfigValue('table_prefix') . 'triples WHERE property="http://outils-reseaux.org/_vocabulary/type") ';
    $sql .= ' ORDER BY tag ASC';

    $output = '';
    $pages = $this->LoadAll($sql);
    foreach ($pages as $page) {
        $body = _convert($page['body'], 'utf-8');
        // titres 1
        $body = preg_replace('/# (.*?)/ui', '======$1======', $body);
        // titres 2
        $body = preg_replace('/## (.*?)/ui', '=====$1=====', $body);
        // titres 3
        $body = preg_replace('/### (.*?)/ui', '====$1====', $body);
        // titres 4
        $body = preg_replace('/#### (.*?)/ui', '===$1===', $body);
        // titres 5
        $body = preg_replace('/##### (.*?)/ui', '==$1==', $body);
        // liens
        $body = preg_replace('/\[(.*?)]\((.*?)\)/uim', '[[$2 $1]]', $body);
        // italique
        $body = preg_replace('/\*(.*?)\*/uim', '//$1//', $body);
        // code
        $body = preg_replace('/\%\%(.*?)\%\%/uim', '```'."\n".'$1'."\n".'```', $body);
        // passage en html
        $body = preg_replace('/""(.*?)""/uim', '$1'."\n\n", $body);
        $output .= '<h2>'.$page['tag'].'</h2>'.nl2br($body).'<hr>';

        // $query  = 'UPDATE '.$this->GetConfigValue('table_prefix').'pages ';
        // $query .= 'SET body="'. mysqli_real_escape_string($this->dblink, chop($body)) .'" ';
        // $query .= 'WHERE tag="'.$page['tag'].'" AND latest="Y"';
        // echo $query;
        $this->SavePage($page['tag'], $body);
    }
    echo $this->header()
     .'<div class="alert alert-success">'._t('handler markdown2wakka : toutes les pages ont été transformées en syntaxe wakka.').'</div>'
     .$output
     .$this->footer();
} else {
    echo $this->header()
     .'<div class="alert alert-danger">'._t('handler markdown2wakka : réservé aux administrateurs.').'</div>'
     .$this->footer();
}