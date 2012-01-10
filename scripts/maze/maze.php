<?php

class Wall {

    public $val;

    function __construct() {
        $this->val = true;
    }

}

class Cell {

    public $sides;

    private $n_sides;

    function __construct($n_sides) {
        $this->n_sides = $n_sides;
        $this->sides = array();
        foreach(range(0, $this->n_sides-1) as $i) {
            array_push($this->sides, array("wall"=>new Wall, "cell"=>null));
        }
    }

    function remove_wall($i) {
        $this->sides[$i]["wall"]->val = false;
    }
}

class Maze {

    public $grid, $solution;

    private $rows, $cols, $cell_width, $cell_height;

    function __construct($rows, $cols, $cell_width, $cell_height) {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->cell_width = $cell_width;
        $this->cell_height = $cell_height;

        $this->grid = array();

        foreach(range(0, $this->cols-1) as $i) {
            $col = array();
            foreach(range(0, $this->rows-1) as $j) {
                array_push($col, new Cell(4));
            }
            array_push($this->grid, $col);
        }
        foreach($this->grid as $ci=>$col) {

            foreach($col as $ri=>$row) {

                if($ci > 0) {
                    $this->grid[$ci][$ri]->sides[1]["cell"] = $this->grid[$ci-1][$ri];
                    $this->grid[$ci][$ri]->sides[1]["wall"] = $this->grid[$ci-1][$ri]->sides[3]["wall"];
                }
                if($ri > 0) {
                    $this->grid[$ci][$ri]->sides[0]["cell"] = $this->grid[$ci][$ri-1];
                    $this->grid[$ci][$ri]->sides[0]["wall"] = $this->grid[$ci][$ri-1]->sides[2]["wall"];
                }
                if($ci < $this->cols-1) {
                    $this->grid[$ci][$ri]->sides[3]["cell"] = $this->grid[$ci+1][$ri];
                }
                if($ri < $this->rows-1) {
                    $this->grid[$ci][$ri]->sides[2]["cell"] = $this->grid[$ci][$ri+1];
                }

            }
        }
        $this->solution = array();
        $this->dfs();
    }

    private function dfs() {
        $visited = array();
        foreach(range(0, $this->cols-1) as $cols) {
            $col = array();
            foreach(range(0, $this->rows-1) as $rows) {
                array_push($col, false);
            }
            array_push($visited, $col);
        }
        $backtrack = array();
        $i = 0;
        $j = 0;
        while(!($visited[$i][$j] && sizeof($backtrack)<1)) {

            $visited[$i][$j] = true;
            $coord_x = array(0, -1, 0, 1);
            $coord_y = array(-1, 0, 1, 0);
            $possibles = array();
            foreach(range(0, 3) as $x) {
                $i_new = $i + $coord_x[$x];
                $j_new = $j + $coord_y[$x];
                if($i_new>=0 && $i_new<=$this->cols-1 && $j_new>=0 && $j_new<=$this->rows-1) {
                    if(!$visited[$i_new][$j_new]) {
                        array_push($possibles, array("direction"=>$x, "coordinates"=>array($i_new, $j_new)));
                    }
                }
            }
            if(sizeof($possibles)>0) {
                $next_cell = $possibles[array_rand($possibles)];
                array_push($backtrack, array($i, $j));
                $this->grid[$i][$j]->remove_wall($next_cell["direction"]);
                $i = $next_cell["coordinates"][0];
                $j = $next_cell["coordinates"][1];
                continue;
            }
            elseif(sizeof($backtrack) != 0) {
                if($i == $this->cols-1 && $j == $this->rows-1) {
                    $this->solution = $backtrack;
                    array_push($this->solution, array($i, $j));
                }
                $next_cell = array_pop($backtrack);
                $i = $next_cell[0];
                $j = $next_cell[1];
                continue;
            }
        }
    }

    public function write_to(&$arr) { 
        $polyline = "";
        foreach($this->solution as $point) {
            $polyline .= $this->cell_width*($point[0]+0.5) . "," . $this->cell_height*($point[1]+0.5) . " ";
        }

        array_push($arr, $polyline);

        $id_array = array(array(array(1, 0), array(0, 0)),
                          array(array(0, 0), array(0, 1)),
                          array(array(0, 1), array(1, 1)),
                          array(array(1, 1), array(1, 0)));
        foreach($this->grid as $ci=>$col) {
            foreach($col as $ri=>$cell) {
                $lines = array();
                foreach($id_array as $i=>$edge) {
                    if($i != 2 || $ri==$this->rows-1) {
                        if($i !=3 || $ci==$this->cols-1) {
                            if($cell->sides[$i]["wall"]->val) {
                                array_push($lines, $edge);
                            }
                        }
                    }
                }
                foreach($lines as $edge) {
                    $c1 = $edge[0];
                    $c2 = $edge[1];
                    
                    $cx = $ci+floor(($c1[0]+$c2[0])/2);
                    $cy = $ri+floor(($c1[1]+$c2[1])/2);

                    $dir = ($c1[0] == $c2[0]) ? "v" : "h";

                    $id = $dir . $cx . "_" . $cy;

                    $x1 = $this->cell_width*($ci+$c1[0]);
                    $x2 = $this->cell_width*($ci+$c2[0]);
                    $y1 = $this->cell_height*($ri+$c1[1]);
                    $y2 = $this->cell_height*($ri+$c2[1]);

                    array_push($arr, "id=\"" . $id . "\" x1=\"" . $x1 . "\" x2=\"" . $x2 . "\" y1=\"" . $y1 . "\" y2=\"" . $y2 . "\"");
                }
            }
        }

    }
}
