<?php

class Tictactoe
{
  private $matrix;
  private $playerChar;
  private $computerChar;

  public function __construct( string $playerChar, array $matrix ) {

    $this->playerChar = $playerChar;

    $this->computerChar = $this->playerChar == 'x' ? 'o' : 'x';

    $this->matrix = $matrix;

  }

  static function generateEmptyMatrix():array {
    $matrix = [[]];

    for($y = 0; $y < 3; $y++) {
      for($x = 0; $x < 3; $x++) {
        $matrix[$y][$x] = 0;
      }
    }

    return $matrix;
  }

  public function mark(int $x, int $y ):bool {
    if ($this->matrix[$y][$x] !== 0) {
      return false;
    }
    else {
      $this->matrix[$y][$x] = $this->playerChar;
      return true;
    }
  }

  public function computerMark():bool {
    for($y = 0; $y < count($this->matrix); $y++) {
      for($x = 0; $x < count($this->matrix[$y]); $x++) {
        if ($this->matrix[$y][$x] === 0) {
          $this->matrix[$y][$x] = $this->computerChar;
          return true;
        }
      }
    }
    return false;
  }

  public function checkWin():bool {
    // brute force
    
    // horizontal
    if (    $this->matrix[0][0] === $this->matrix[1][0]
         && $this->matrix[0][0] === $this->matrix[2][0]
         && $this->matrix[0][0] !== 0) {
      return true;
    }
    elseif ( $this->matrix[0][1] === $this->matrix[1][1]
          && $this->matrix[0][1] === $this->matrix[2][1]
          && $this->matrix[0][1] !== 0) {
      return true;
    }
    elseif ( $this->matrix[0][2] === $this->matrix[1][2]
          && $this->matrix[0][2] === $this->matrix[2][2]
          && $this->matrix[0][2] !== 0) {
      return true;
    }
    // vertical
    elseif ( $this->matrix[0][0] === $this->matrix[0][1]
          && $this->matrix[0][0] === $this->matrix[0][2]
          && $this->matrix[0][0] !== 0) {
      return true;
    }
    elseif ( $this->matrix[1][0] === $this->matrix[1][1]
          && $this->matrix[1][0] === $this->matrix[1][2]
          && $this->matrix[1][0] !== 0) {
      return true;
    }
    elseif ( $this->matrix[2][0] === $this->matrix[2][1]
          && $this->matrix[2][0] === $this->matrix[2][2]
          && $this->matrix[2][0] !== 0) {
      return true;
    }
    // crossed
    elseif ( $this->matrix[0][0] === $this->matrix[1][1]
          && $this->matrix[0][0] === $this->matrix[2][2]
          && $this->matrix[0][0] !== 0) {
      return true;
    }
    elseif ( $this->matrix[0][2] === $this->matrix[1][1]
          && $this->matrix[0][2] === $this->matrix[2][0]
          && $this->matrix[0][2] !== 0) {
      return true;
    }
    // no win
    else {
      return false;
    }
  }

  public function getMatrix():array {
    return $this->matrix;
  }

  public function getPlayerChar():string {
    return $this->playerChar;
  }

  public function getComputerChar():string {
    return $this->computerChar;
  }
}
