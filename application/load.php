<?php

function view($file_name, $data)
{
    if(is_array($data)) {
        extract($data);
    }
    include 'views/' . $file_name;
}

?>
