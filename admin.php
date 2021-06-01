<?php
/*
 * 
 * Text modules Plugin
 *
 * @author: Gero Gothe <gero.gothe@medizindoku.de>
 * License: GPL2
 * 
 */
 

class admin_plugin_textmodule extends DokuWiki_Admin_Plugin {
     
    function getMenuText($language){
        return $this->getLang("text module");
    }

    function forAdminOnly() {
        return false;
    }
    
    /* Loads the saved textmodules from the file data/modules/modules.txt
     * 
     * Format: (per line Basis)
     * Title 1
     * Module 1 shortcut:Module t Text
     * [...]
     * Module n shortcut: Module n text
     * [TEXTMODULE DELIMITER]
     * Title 2
     * [...]
    */
    function _loadModules() {
        if (file_exists('data/meta/modules.txt')) {
            $t = file_get_contents('data/meta/modules.txt');
            $t = explode("\n[TEXT MODULE DELIMITER]\n",$t);
            foreach ($t as &$m) $m = explode(PHP_EOL,$m);
            return $t;
            
        }
        return Array(Array('',''),Array('',''),Array('',''));
    }
    
    
    /* Save the form data */
    function handle(){
        if (!isset($_REQUEST)) return;
        
        if (isset($_REQUEST['Save'])) {
            $r = $_REQUEST['title1'] . "\n" . trim($_REQUEST['text1']) . "\n[TEXT MODULE DELIMITER]\n" . $_REQUEST['title2'] . "\n" . trim($_REQUEST['text2']) . "\n[TEXT MODULE DELIMITER]\n" . $_REQUEST['title3']. "\n" . trim($_REQUEST['text3']);
            file_put_contents('data/meta/modules.txt',$r);
        }
    }
     
    
    /* Output HTML for the admin section */
    function html() {
        echo '<h1>'.$this->getLang("text module").' Plugin</h1>';
        echo $this->getLang("admin help").'<br>';
        
        $m = $this->_loadModules();       
        
        echo '<form action="'.wl($ID).'" method="post">';

        # output hidden values to ensure dokuwiki will return back to this plugin
        echo '<input type="hidden" name="do"   value="admin" />';
        echo '<input type="hidden" name="page" value="'.$this->getPluginName().'" />';
        
        for ($c=1;$c<4;$c++) {
            echo '<br><br><hr>';
            echo $this->getLang("title").' '.$c.': <input type="text" name="title'.$c.'" value="'.($m[$c-1][0]).'"><br><br>';
            echo '<textarea name="text'.$c.'" style="width:100%;height:10vw">'.implode("\n",array_slice($m[$c-1],1)).'</textarea>';
        }
        
        echo '<br><br><input name="Save" type="submit" value="Save">';
        echo '</form>';
    }

}

