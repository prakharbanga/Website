<?php

class html
{
    private $html = array();
    private $parent = null;

    function __construct($inner='', $type='no_tag', $attrs=array())
    {
        $this->put($inner, $type, $attrs);
    }

    public function put($inner, $type='no_tag', $attrs=array())
    {
        array_push($this->html, array(
                    'type' => $type,
                    'attrs' => $attrs,
                    'inner' => $inner));
    }

    public function render($parent = null) {
        $this->parent = $parent;
        $string = '';
        foreach ($this->html as $tag) {
            $to_add = '';
            switch($tag['type']) {
                case 'no_tag':
                    switch($tag['inner']) {
                        case 'newline':
                            $to_add .= '<br />';
                            break;
                        case 'p':
                            $to_add .= '<p />';
                            break;
                        default:
                            $to_add .= (!is_string($tag['inner'])) ? ($tag['inner']->render($this)) : ($tag['inner']);
                    }
                    break;
                default:
                    $to_add .= '<' . $tag['type'];
                    foreach ($tag['attrs'] as $attr) {
                        $value_string = '';
                        if(is_array($attr['value'])) {
                            foreach($attr['value'] as $value) {
                                $value_string .= $this->dynamic_get($value);
                            }
                        } else {

                            $value_string = $this->dynamic_get($attr['value']);

                        }
                        $to_add .= ' ' . $attr['name'] . '="' . $value_string . '"';

                    }
                    $to_add .= '>';
                    $to_add .= (!is_string($tag['inner'])) ? ($tag['inner']->render($this)) : ($tag['inner']);
                    $to_add .= '</' . $tag['type'] . '>';
            }
            $string .= $to_add;
        }
        return $string;
    }

    private function dynamic_get($var_name) {
            return isset($this->$var_name) ? $this->$var_name : (isset($this->parent) ? $this->parent->dynamic_get($var_name) : $var_name);
    }

    public function set_variable($var_name, $value) {
        $this->$var_name = $value;
        return $this->$var_name;
    }
}


?>
