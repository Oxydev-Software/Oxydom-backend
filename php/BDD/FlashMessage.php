<?php

class FlashMessage{

    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_INFO    = 'info';
    const TYPE_ERROR   = 'danger';

    const ICON_SUCCESS = 'glyphicons-ok-sign';
    const ICON_WARNING = 'glyphicons-warning-sign';
    const ICON_INFO    = 'glyphicons-info-sign';
    const ICON_ERROR   = 'glyphicons-remove-sign';

    public static function add($type = 'success', $md_icon = 'check', $mot = 'Success', $msg){
        $_SESSION['flashmessage'][] = array($type, $md_icon, $mot, $msg);
        return $_SESSION['flashmessage'];
    }

    public static function afficheMessages(){
        self::getAll();
        self::clear();
        FlashMessage::clear();
        echo '
            <script>
                $("#div-flash").delay(10000).slideUp(1000);
            </script>
            ';
    }

    /**
     * Affiche tous les flashMessages
     * @return array
     */

    public static function getAll(){
        if (isset($_SESSION['flashmessage']) && count($_SESSION['flashmessage']) > 0) {
            echo '<div id="div-flash">';
            foreach ($_SESSION['flashmessage'] as $flashmessage){
                echo '
                    <div class="alert alert-'.$flashmessage['0'].' alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <strong><span class="glyphicon '.$flashmessage['1'].'" style="vertical-align: middle;"></span> '.$flashmessage['2'].' </strong> '.$flashmessage['3'].'
                    </div>';
            }
            echo '</div>';
        }
    }

    /**
     * Supprime les flash message
     */
    public static function clear(){
        $_SESSION['flashmessage'] = array();
    }
}



