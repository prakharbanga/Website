<?php

$to_have_maze = true;

$rows = 20;
if(isset($_GET['rows'])) {
    $rows_t = $_GET['rows'];
    if(filter_var($rows_t, FILTER_VALIDATE_INT,
                array("options"=>
                    array("min_range"=>1)))) {
        $rows = $rows_t;
    }
}

$cell_rows = $rows;
$cols = 20;
if(isset($_GET['cols'])) {
    $cols_t = $_GET['cols'];
    if(filter_var($cols_t, FILTER_VALIDATE_INT,
                array("options"=>
                    array("min_range"=>1)))) {
        $cols = $cols_t;
    }
}

if($rows*$cols > 4100) {
    $to_have_maze = false;
}

$cell_rows = $rows;
$cell_cols = $cols;
$cell_width = 5;
$cell_height = 5;
$stroke_width = 1;
$em_per_unit = 0.15;

$t_width = ($cell_width*$cols+$stroke_width);

$t_height = ($cell_height*$rows+$stroke_width);

$pointer_radius = 1.5;
$initial_pointer_x = 0;
$initial_pointer_y = 0;
$solution_width = min($cell_width, $cell_height)/2.0;
$solution_initially = "false";

$scroll_pixels = 5;

if($to_have_maze) {

    require('./scripts/maze/maze.php');

    $im = array();

    $mz = new Maze($rows, $cols, $cell_width, $cell_height);

    $mz->write_to($im);
    
}

$sol_hide_string = "Hide solution";
$sol_show_string = "Show solution";

$sol_button_initial_value =  $solution_initially == "true" ? $sol_hide_solution : $sol_show_string;

if(isset($_GET['back'])) {

    $back_link = "<a href=\"" . $_GET['back'] . "\">Go back</a>\n";

} else {
    $back_link = "";
}

$level_value = "?script=" . $_GET['script'] . ( isset($_GET['back']) ? ( "&back=" . $_GET['back'] ) : "" );

require("./views/maze_view.php");

?>
