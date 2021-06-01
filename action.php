<?php
/*
 * 
 * Text modules Plugin
 *
 * @author: Gero Gothe <gero.gothe@medizindoku.de>
 * License: GPL2
 * 
 */
 

if ( !defined( 'DOKU_INC' ) ) die();

if ( !defined( 'DOKU_PLUGIN' ) ) define( 'DOKU_PLUGIN', DOKU_INC . 'lib/plugins/' );

require_once( DOKU_PLUGIN . 'action.php' );

class action_plugin_textmodule extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('HTML_EDITFORM_OUTPUT', 'BEFORE', $this,'handle_editform_output');
    }
    
    
    /* Create the div-containers for the textmodules */
    function _format_modules() {
        if (file_exists('data/meta/modules.txt')) {
            $t = file_get_contents('data/meta/modules.txt');
            $t = explode("\n[TEXT MODULE DELIMITER]\n",$t);
            $r = '';
            foreach ($t as $m) {
                $m = explode(PHP_EOL,trim($m));
                
                if (count($m)>1) {
                    
                    $title = trim($m[0]);
                    if (strlen($title)==0)  $title = $this->getLang("text module");
                    $r .= '<div id="textmodule_'.$title.'" class="plugin_textmodule_box" onclick="textmodule_expand(this.id)">';
                    $r.= '<div style="text-align:center;width:100%">'.$title.'</div>';
                    
                    
                    for ($c=1;$c<Count($m);$c++) {
                        
                        # Check for separator ":"
                        $n = strpos($m[$c],":");
                        if ($n == 0) {
                            $t1 = trim($m[$c]);
                            $t2 = $t1;
                        } else {
                            $t1 = trim(substr($m[$c],0,$n));
                            $t2 = trim(substr($m[$c],$n+1));
                        }
                        
                        $r .= '<a class="plugin_textmodule_link" onclick="textmodule_snippet(\''.$t2.'\')">'.$t1.'</a> ';
                    }
                    
                    $r .= '</div>';
                }
            }
            return $r;
        }
    }

    /* Create the additional fields for the edit form. */
    function handle_editform_output( &$event, $param ) {
        $pos = $event->data->findElementByAttribute( 'type', 'submit' );
        if ( !$pos ){ return; }
        
        $out = '<div>';
        $out .= $this->_format_modules();
        $out .= '</div>';
        
        $event->data->insertElement( $pos++, $out );
    }

}
