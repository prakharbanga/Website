<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<script type="text/javascript"> 

var pointer_x = <?= $initial_pointer_x ?>;
var pointer_y = <?= $initial_pointer_y ?>;

document.onkeydown = keyPressHandler; 

function keyPressHandler(e) { 
    if(document.getElementById('<?= $last_line ?>') == null) { 
        return;
    } 
    k = e.keyCode; 
    if(k==38 || k==75) { 
        e.preventDefault(); 
        if(document.getElementById(pointer_x+','+pointer_y+'h') == null) { 
            pointer_y -= 1; 
        } 
        else { 
            window.scrollBy(0, -<?= $scroll_pixels ?>); 
        } 
    } 
    if(k==40 || k==74) { 
        e.preventDefault(); 
        if(document.getElementById(pointer_x+','+(pointer_y+1)+'h') == null) { 
            pointer_y += 1; 
        } 
        else { 
            window.scrollBy(0, <?= $scroll_pixels ?>); 
        } 
    } 
    if(k==37 || k==72) { 
        e.preventDefault(); 
        if(document.getElementById(pointer_x+','+pointer_y+'v') == null) { 
            pointer_x -= 1; 
        } 
        else { 
            window.scrollBy(-<?= $scroll_pixels ?>, 0); 
        } 
    } 
    if(k==39 || k==76) { 
        e.preventDefault(); 
        if(document.getElementById((pointer_x+1)+','+pointer_y+'v') == null) { 
            pointer_x += 1; 
        } 
        else { 
            window.scrollBy(<?= $scroll_pixels ?>, 0); 
        } 
    } 
    refresh_pointer(); 
} 
function refresh_pointer() { 
    var pointer = document.getElementById('pointer'); 
    pointer.setAttributeNS(null, "cx", <?= $cell_width ?>*(pointer_x+0.5)); 
        pointer.setAttributeNS(null, "cy", <?= $cell_height ?>*(pointer_y+0.5)); 
} 
var solution = <?= $solution_initially ?>;
function toggle_solution() { 
    var new_value = solution ? "hidden" : "visible"; 
        var new_display = solution ? "<?= $sol_show_string ?>" : "<?= $sol_hide_string ?>";
        solution = !solution; 
    sol_line = document.getElementById("solution"); 
        sol_line.setAttributeNS(null, "visibility", new_value); 
        sol_button = document.getElementById("sol_button"); 
        sol_button.setAttributeNS(null, "value", new_display) 
} 
</script> 
</head> 
<body> 
Navigate your way through the grid using the arrow keys, or the 'h', 'j', 'k', 'l' keys. Try to reach the bottom-right corner.
<p />

<?php

foreach($im as $line) {
    echo $line . "\n";
}

?>

<p /> 

<input id="sol_button" type="button" value="<?= $sol_button_initial_value ?>" onclick="toggle_solution()" />

<p />

<?= $back_link ?>

</body>

</html>
