<?php
/**
 * Created by PhpStorm.
 * User: wal04
 * Date: 25/03/15
 * Time: 16:45
 */

/* Fonction pour afficher le prix proprement */
function price($prix){
    return"<b>".number_format($prix, 2, ',', ' ')."</b> €";
}

/* Fonction pour générer mes étoiles */
function generatestar($nb) {
    return str_repeat('<span class="fa fa-star"></span>', $nb);
}

/* Fonction qui gère la visibilité */
function visibility($visible){
    if($visible == true) {
        return "<i class='icone-oeil fa fa-eye'></i>";
    }else{
        return "<i class='icone-oeil fa fa-eye-slash'></i>";
    }
}

/* Fonction qui gère la couverture */
function cover($cover) {
    if($cover == true) {
        return "<i class='fa fa-star text-success'></i>";
    }else {
        return "";
    }
}

function readmore($text, $limit, $lien) {
    $html = substr(utf8_encode(htmlentitoes(strip_tags($text), ENT_QUOTES, 'UTF-8')), 0, strpos(wordwrap($text, $limit), "\n"))." ...";
    $html .= "<a href=".$lien.">
                lire la suite
              </a>";
    return $html;
}

function readmoremodal($text, $limit) {
    $html = substr(strip_tags($text), 0, strrpos(substr(strip_tags($text), 0, $limit), ' '));
    return $html;
}

function embed($iframe) {
    $html = '<div class="embed-responsive embed-responsive-16by9">'.
                $iframe
            .'</div>';
    return $html;
}

function ago($time) {
    $periods = array("seconde", "minute", "heure", "jour", "semaine", "mois", "année", "décénie");
    $lengths = array("60","60","24","7","4.35","12","10");

    $now = time();

    $difference = $now - strtotime($time);

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = abs(round($difference));

    if($difference != 1 && $periods[$j] != "mois") {
        $periods[$j].= "s";
    }

    return "<span class='fa fa-dashboard text-warning'></span> Il y a ".$difference ." ". $periods[$j];

}