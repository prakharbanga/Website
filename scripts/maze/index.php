<?php

require('./scripts/maze/values.php');

$rows = 20;
if(isset($_GET['rows'])) {
    $rows_t = $_GET['rows'];
    if(filter_var($rows_t, FILTER_VALIDATE_INT,
                array("options"=>
                    array("min_range"=>1)))) {
        $rows = $rows_t;
    }
}

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

$t_width = ($cell_width*$cols+$stroke_width);

$t_height = ($cell_height*$rows+$stroke_width);

if($to_have_maze) {

    require('./scripts/maze/maze.php');

    $im = array();

    $mz = new Maze($rows, $cols, $cell_width, $cell_height);

    $mz->write_to($im);
    
}

if(isset($_GET['back'])) {

    $back_link = "<a href=\"" . $_GET['back'] . "\">Go back</a>\n";

} else {
    $back_link = "";
}

$level_value = "?script=" . $_GET['script'] . ( isset($_GET['back']) ? ( "&amp;back=" . $_GET['back'] ) : "" );

require("./views/maze/maze_view.php");

?>
