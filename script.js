/* 
 * Gero Gothe <gero.gothe@medizindoku.de>
 * 
 * License: GPL2
 * 
 */

/* Adds the chosen text module at the current cursor position */
function textmodule_snippet(t){                    
    cursorPos = document.getElementById('wiki__text').selectionStart;
    
    let x = document.getElementById('wiki__text').value;
    document.getElementById('wiki__text').value = x.slice(0,cursorPos) + t + x.slice(cursorPos);
    
    // Set cursor back to initial position
    document.getElementById('wiki__text').focus();
    
    document.getElementById('wiki__text').selectionStart = cursorPos;
    document.getElementById('wiki__text').selectionEnd = cursorPos;
}


/* Expand/collapse the group of textmodules by changing the css class */
function textmodule_expand(id) {
    if (document.getElementById(id).className == "plugin_textmodule_box_active") {
        document.getElementById(id).className = "plugin_textmodule_box";
    } else document.getElementById(id).className = "plugin_textmodule_box_active";

}
