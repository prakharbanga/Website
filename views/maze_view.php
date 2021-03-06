<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:svg="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

<title>
The maze
</title>
<script type="text/javascript"> 

<?php if($to_have_maze): ?>

var pointer_x = <?= $initial_pointer_x ?>;
var pointer_y = <?= $initial_pointer_y ?>;

var pointer_lock = false;

function attempt_lock_pointer() {
    if(!pointer_lock) {
        pointer_lock = true;
        return true;
    }
    else {
        return false;
    }
}

function unlock_pointer() {
    pointer_lock = false;
}

document.onkeydown = keyPressHandler; 

function keyPressHandler(e) { 
    if(document.getElementById('pointer') == null) { 
        return;
    } 
    k = e.keyCode; 
    if(k==38 || k==75) { 
        e.preventDefault(); 
        if(document.getElementById(pointer_x+','+pointer_y+'h') == null) { 
            move_pointer_up();
        } 
        else { 
            scroll_window_up();
        } 
    } 
    if(k==40 || k==74) { 
        e.preventDefault(); 
        if(document.getElementById(pointer_x+','+(pointer_y+1)+'h') == null) { 
            move_pointer_down();
        } 
        else { 
            scroll_window_down();
        } 
    } 
    if(k==37 || k==72) { 
        e.preventDefault(); 
        if(document.getElementById(pointer_x+','+pointer_y+'v') == null) { 
            move_pointer_left();
        } 
        else { 
            scroll_window_left();
        } 
    } 
    if(k==39 || k==76) { 
        e.preventDefault(); 
        if(document.getElementById((pointer_x+1)+','+pointer_y+'v') == null) { 
            move_pointer_right();
        } 
        else { 
            scroll_window_right();
        } 
    } 
} 

function scroll_window_up() {
    if(!attempt_lock_pointer) return;
    window.scrollBy(0, -<?= $scroll_pixels ?>);
    unlock_pointer();
}

function scroll_window_down() {
    if(!attempt_lock_pointer) return;
    window.scrollBy(0, <?= $scroll_pixels ?>);
    unlock_pointer();
}

function scroll_window_left() {
    if(!attempt_lock_pointer) return;
    window.scrollBy(-<?= $scroll_pixels ?>, 0);
    unlock_pointer();
}

function scroll_window_right() {
    if(!attempt_lock_pointer) return;
    window.scrollBy(<?= $scroll_pixels ?>, 0);
    unlock_pointer();
}

var speed = 1;

function move_pointer_up() {
    if(!attempt_lock_pointer) return;
    pointer_y -= speed;
    refresh_pointer();
    unlock_pointer();
}

function move_pointer_down() {
    if(!attempt_lock_pointer) return;
    pointer_y += speed;
    refresh_pointer();
    unlock_pointer();
}

function move_pointer_left() {
    if(!attempt_lock_pointer) return;
    pointer_x -= speed;
    refresh_pointer();
    unlock_pointer();
}

function move_pointer_right() {
    if(!attempt_lock_pointer) return;
    pointer_x += speed;
    refresh_pointer();
    unlock_pointer();
}

var to_show_congrats = true;

function refresh_pointer() { 
    var pointer = document.getElementById('pointer'); 
    pointer.setAttributeNS(null, "cx", <?= $cell_width ?>*(pointer_x+0.5)); 
    pointer.setAttributeNS(null, "cy", <?= $cell_height ?>*(pointer_y+0.5)); 
    if(to_show_congrats && pointer_x == <?= $cell_cols-1 ?> && pointer_y == <?= $cell_rows-1 ?>) {
        alert("Congratulations.");
        to_show_congrats = false;
        pointer.setAttributeNS(null, "fill", "rgb(0,255,0)");
    }
} 

var solution = <?= $solution_initially ?>;

function toggle_solution() { 
    var new_value = solution ? "hidden" : "visible";
    var new_display = solution ? "<?= $sol_show_string ?>" : "<?= $sol_hide_string ?>";
    solution = !solution; 
    sol_line = document.getElementById("solution"); 
    sol_line.setAttributeNS(null, "visibility", new_value); 
    sol_button = document.getElementById("sol_button"); 
    sol_button.setAttributeNS(null, "value", new_display);

    pointer = document.getElementById("pointer");
    if(to_show_congrats) {
        to_show_congrats = false;
        pointer.setAttributeNS(null, "fill", "rgb(0,0,255)");
    }
}

<?php endif; ?>

function choose(select) {
    if(select.value != null) {
        location = select.value;
    }
}

function choose_rows_cols(rows, cols) {
    to_go_to = "<?= $level_value ?>&rows=" + rows + "&cols=" + cols;
    location = to_go_to;
}

</script> 
</head> 
<body> 

<?php if($to_have_maze): ?>
<p>
This page displays and works alright in the latest versions of Firefox, Google Chrome and Opera. Javascript is required to play the game.
</p>
<p>
Navigate your way through the grid using the arrow keys, or the 'h', 'j', 'k', 'l' keys.
<br />
Try to reach the bottom-right corner.
</p>

<p>

<?php

echo "<svg version=\"1.1\" viewBox=\"0 0 " . $t_width . " " . $t_height . "\" width=\"" . ($t_width*$em_per_unit) . "em\" " . " height=\"" . ($t_height*$em_per_unit) . "em\">" . "\n";

$pl = array_shift($im);

echo "<g id=\"group\" transform=\"translate(" . $stroke_width/2.0 . ", " . $stroke_width/2.0 . ")\">\n";

echo "<polyline id=\"solution\" visibility=\"" . ( $solution_initially == "true" ? "visible" : "hidden" ) . "\" points=\"" . $pl . "\" style=\"fill:none;stroke:rgb(255,255,0);stroke-width:$solution_width\"/>\n";

foreach($im as $line) {
    echo "<line " . $line . " style=\"stroke-linecap:square;stroke:rgb(0,0,0);stroke-width:$stroke_width\" />\n";

}

echo "<circle id=\"pointer\" cx=\"" . $cell_width*($initial_pointer_x+0.5) . "\" cy=\"" . $cell_height*($initial_pointer_y+0.5) . "\" r=\"" . $pointer_radius . "\" fill=\"rgb(255,0,0)\" />\n";

echo "</g>\n";

echo "</svg>\n";

?>
</p>

<p>
<input id="sol_button" type="button" value="<?= $sol_button_initial_value ?>" onclick="toggle_solution()" />
</p>

<p>
Too easy or too hard?

<?php else: ?>

<p>
<p>
Sorry, but really large mazes put too much load on the server. I might solve this problem in the near future.
</p>

<?php endif; ?>

<?php $levels = array(array(20, 20),
                      array(30, 40),
                      array(40, 60),
                      array(40, 80),
                      array(45, 90)); ?>

<select name="choose_level" onchange="choose(this)">
<option>Choose another size</option>
<?php foreach($levels as $level): ?>
<option value="<?= $level_value ?>&rows=<?= $level[0] ?>&cols=<?= $level[1] ?>"><?= $level[0] ?>x<?= $level[1] ?></option>
<?php endforeach; ?>
</select>
</p>
Or choose custom size: 
<input id="rows_text" type="text">x<input id="cols_text" type="text">
<button onclick="choose_rows_cols(document.getElementById('rows_text').value, document.getElementById('cols_text').value)">Go!</button>

<p>
<?= $back_link ?>
</p>

</body>

</html>
