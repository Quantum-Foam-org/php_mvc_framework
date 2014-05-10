<?php

namespace \local\classes\utility;

class HtmlCreate {
    
    // hope to use dom document for all view/tpl items
    public static function get_dom_doc() {
        
    }
    
    public static function select_field($id, $name = null, array $options, $selected=null) {
        if ($name === null) {
            $name = $id;
        }
        
        $options_elements = self::create_select_opts($options, $selected);
        
        return <<<EOT
<select id="$id" name="$name">
$options_elements
</select>
EOT;
    }
    
    private static function create_select_opts(array & $options, $selected=null) {
        $option_html = array();
        
        foreach ($options as $i => $opt) {
            $opt = htmlspecialchars($opt);
            $option_html[$i] = '<option value="'.$i.'" ';
            if ($selected == $i) {
                $option_html[$i] .= 'selected="selected"';
            } 
            
            $option_html[$i] .= '>'.$opt.'</option>';
        }
        
        
        return implode("\n", $option_html);
    }
}
