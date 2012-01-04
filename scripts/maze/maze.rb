class Wall

  attr_accessor :value

  def initialize
    @value = true
  end

end

class Cell

  attr_accessor :sides

  def initialize(n_sides)
    @n_sides = n_sides
    @sides = Array.new(@n_sides) { { :wall=>Wall.new, :cell=>nil } }
  end

  def remove_wall(i)
    @sides[i][:wall].value = false
  end

end

class Maze

  attr_accessor :grid
  attr_accessor :solution

  def initialize(rows, cols)
    @rows, @cols = rows, cols
    @grid = Array.new(@cols) { Array.new(@rows) { Cell.new(4) } }
    @grid.each_with_index { |col, ci|
      col.each_with_index { |cell, ri|
        if(ci > 0)
          @grid[ci][ri].sides[1][:cell] = @grid[ci-1][ri]
          @grid[ci][ri].sides[1][:wall] = @grid[ci-1][ri].sides[3][:wall]
        end
        if(ri > 0)
          @grid[ci][ri].sides[0][:cell] = @grid[ci][ri-1]
          @grid[ci][ri].sides[0][:wall] = @grid[ci][ri-1].sides[2][:wall]
        end
        if(ci < @cols-1)
          @grid[ci][ri].sides[3][:cell] = @grid[ci+1][ri]
        end
        if(ri < @rows-1)
          @grid[ci][ri].sides[2][:cell] = @grid[ci][ri+1]
        end
      }
    }
    @solution = Array.new()
  end

  def dfs
    visited = Array.new(@cols) { Array.new(@rows, false) }
    backtrack = Array.new()
    i, j = 0, 0
    until visited[i][j] && backtrack.size < 1
      visited[i][j] = true
      next_cell = [0, 1, 2, 3].collect { |x|
        if (i_new = i + [0, -1, 0, 1][x]).between?(0, @cols-1) &&
             (j_new = j + [-1, 0, 1, 0][x]).between?(0, @rows-1) && !visited[i_new][j_new]
          {:direction=>x, :coordinates=>[i_new,j_new]}
        end
      }.compact.choice
      if next_cell
        backtrack.push([i,j])
        @grid[i][j].remove_wall(next_cell[:direction])
        i, j = next_cell[:coordinates]
        next
      elsif backtrack != []
        if [i, j] == [@cols-1, @rows-1]
            @solution = backtrack.dup.push([i, j])
        end
        i, j = backtrack.pop
        next
      end
    end
  end

  CELL_WIDTH = ARGV[2].to_i
  CELL_HEIGHT = ARGV[3].to_i
  STROKE_WIDTH = ARGV[4].to_i
  EM_PER_UNIT = ARGV[5].to_f
  POINTER_RADIUS = ARGV[6].to_i
  INITIAL_POINTER_X = ARGV[7].to_i
  INITIAL_POINTER_Y = ARGV[8].to_i
  SOLUTION_WIDTH = ARGV[9].to_i
  SOLUTION_INITIALLY = ARGV[10] == "true"

  def to_svg
    "\n<svg id=\"image\" xmlns=\"http://www.w3.org/2000/svg\"" <<
    " xmlns:xlink=\"http://www.w3.org/1999/xlink\"" <<
    " viewBox=\"0 0" <<
    " #{ t_width = CELL_WIDTH*@cols + STROKE_WIDTH }" <<
    " #{ t_height = CELL_HEIGHT*@rows + STROKE_WIDTH }\"" <<
    " width=\"#{ t_width*EM_PER_UNIT }em\"" <<
    " height=\"#{ t_height*EM_PER_UNIT }em\"" <<
    ">" <<
    "\n<polyline id=\"solution\" visibility=\"#{ SOLUTION_INITIALLY ? "visible" : "hidden" }\" points=\"" <<
    @solution.collect { |point|
        "#{CELL_WIDTH*(point[0]+0.5)},#{CELL_HEIGHT*(point[1]+0.5)}"
    }.intersperse(" ").join <<
    "\" style=\"fill:none;stroke:rgb(255,255,0);stroke-width:#{SOLUTION_WIDTH}\"" <<
    " />" <<
    "\n<g id=\"group\" transform=\"translate(#{STROKE_WIDTH/2.0}, #{STROKE_WIDTH/2.0})\"" <<
    ">" <<
    "\n<circle id=\"pointer\"" <<
    " cx=\"#{CELL_WIDTH*(INITIAL_POINTER_X+0.5)}\"" <<
    " cy=\"#{CELL_HEIGHT*(INITIAL_POINTER_Y+0.5)}\"" <<
    " r=\"#{POINTER_RADIUS}\" fill=\"red\"" <<
    " />" <<
    @grid.each_with_index.collect { |col, ci|
      col.each_with_index.collect { |cell, ri|
        [[[1, 0], [0, 0]], [[0, 0], [0, 1]], [[0, 1], [1, 1]], [[1, 1], [1, 0]]].select.with_index { |edge, i|
          (i!=2 || ri==@rows-1) && (i!=3 || ci==@cols-1) && cell.sides[i][:wall].value
        }.collect { |c1, c2|
          "\n<line id=\"#{[ci, ri].math_op(c1.math_op(c2, :+).map { |x| x/2 }, :+).to_custom_s}" <<
            ["v", "h"][c1.common(c2)[0]] << "\"" <<
            " x1=\"#{CELL_WIDTH*(ci+c1[0])}\" y1=\"#{CELL_HEIGHT*(ri+c1[1])}\"" <<
            " x2=\"#{CELL_WIDTH*(ci+c2[0])}\" y2=\"#{CELL_HEIGHT*(ri+c2[1])}\"" <<
            " style=\"stroke-linecap:square;stroke:rgb(0,0,0);stroke-width:#{STROKE_WIDTH}\" />"
        }
      }
    }.join << 
    "\n</g>" <<
    "\n</svg>"
  end

end

class Array

  def intersperse(item)
    self.zip(Array.new(self.size, item)).flatten[0...-1]
  end

  def to_custom_s
    self.collect { |item| item.to_s }.intersperse(",").join
  end

  def math_op(ar, op)
    self.zip(ar).map { |x| x.reduce(op) }
  end

  def common(ar)
    self.zip(ar).each_with_index.collect { |item, index | if item[0]==item[1] then index end }.compact
  end

end

m = Maze.new(ARGV[0].to_i, ARGV[1].to_i)
m.dfs
print m.to_svg
