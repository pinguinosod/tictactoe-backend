<?php

class Tictactoe
{
    private $matrix;
    private $playerChar;
    private $computerChar;
    private $difficulty;

    public function __construct(string $playerChar, array $matrix, int $difficulty = 2) 
    {
        $this->playerChar = $playerChar;
        $this->computerChar = $this->playerChar == 'x' ? 'o' : 'x';
        $this->matrix = $matrix;
        $this->difficulty = $difficulty;
    }

    static function generateEmptyMatrix():array 
    {
        $matrix = [[]];

        for($y = 0; $y < 3; $y++) {
            for($x = 0; $x < 3; $x++) {
                $matrix[$y][$x] = 0;
            }
        }

        return $matrix;
    }

    public function mark(int $x, int $y ):bool 
    {
        if ($this->matrix[$y][$x] !== 0) {
            return false;
        } else {
            $this->matrix[$y][$x] = $this->playerChar;
            return true;
        }
    }

    private function playRand(): bool 
    {
        $emptyCoords = [];
        for($y = 0; $y < count($this->matrix); $y++) {
            for($x = 0; $x < count($this->matrix[$y]); $x++) {
                if ($this->matrix[$y][$x] === 0) {
                    $emptyCoords[] = [$y,$x];
                }
            }
        }

        if (count($emptyCoords) > 0) {
            $rnd = rand ( 0 , count($emptyCoords)-1 );
            $y = $emptyCoords[$rnd][0];
            $x = $emptyCoords[$rnd][1];
            $this->matrix[$y][$x] = $this->computerChar;
            return true;
        } else { 
            return false;
        }
    }

    public function computerMark():bool
    {
        switch($this->difficulty) {
            case 1: // simplest (just mark the next empty point)
                for($y = 0; $y < count($this->matrix); $y++) {
                    for($x = 0; $x < count($this->matrix[$y]); $x++) {
                        if ($this->matrix[$y][$x] === 0) {
                            $this->matrix[$y][$x] = $this->computerChar;
                            return true;
                        }
                    }
                }
                break;
            case 2: // dumb (rand)
                return $this->playRand();
            case 3: // this should be smarter (not done yet)
                $emptyCoords = [];
                $playerCoords = [];
                $computerCoords = [];

                // fill coords
                for($y = 0; $y < count($this->matrix); $y++) {
                    for($x = 0; $x < count($this->matrix[$y]); $x++) {

                        if ($this->matrix[$y][$x] === 0) {
                            $emptyCoords[] = [$y,$x];
                        } elseif ($this->matrix[$y][$x] === $this->playerChar) {
                            $playerCoords[] = [$y,$x];
                        } elseif ($this->matrix[$y][$x] === $this->computerChar) {
                            $computerCoords[] = [$y,$x];
                        }

                    }
                }

                if (count($emptyCoords) > 0) {

                    if (count($playerCoords) == 1) { // player moved once

                        if ($this->matrix[1][1] === $this->playerChar) { // he started at middle
                            $this->matrix[0][0] = $this->computerChar; // we play bottom left
                            return true;
                        } else {
                            $this->matrix[1][1] = $this->computerChar; // we play middle
                            return true;
                        }

                    } elseif (count($playerCoords) == 2) { // player moved twice
                      
                        if ($playerCoords[0][0] === $playerCoords[1][0]) { // both on same Y axis

                            $y = $playerCoords[0][0];
                            $x = 3 - $playerCoords[0][1] - $playerCoords[1][1]; // $x = 3 - firstX - secondX

                            if ($this->matrix[$y][$x] === 0) { // if its empty, we block him
                                $this->matrix[$y][$x] = $this->computerChar;
                                return true;
                            }

                        } elseif ($playerCoords[0][1] === $playerCoords[1][1]) { // both on same X axis

                            $y = 3 - $playerCoords[0][0] - $playerCoords[1][0]; // $x = 3 - firstX - secondX
                            $x = $playerCoords[0][1];

                            if ($this->matrix[$y][$x] === 0) { // if its empty, we block him
                                $this->matrix[$y][$x] = $this->computerChar;
                                return true;
                            }

                        } elseif ($this->matrix[1][1] === $this->playerChar) { // he got the middle

                            if ($this->matrix[2][0] === $this->playerChar) { // and he got top left
                                $this->matrix[0][2] = $this->computerChar; // we block bottom right
                                return true;
                            } elseif ($this->matrix[0][2] === $this->playerChar) { // and he got bottom right
                                $this->matrix[2][0] = $this->computerChar; // we block top left
                                return true;
                            }

                        }

                    }
                    
                    // if we got here, then just rand
                    return $this->playRand();

                }
                break;
        }
        return false;
    }

    public function checkWin():bool
    {
        if (    $this->matrix[0][0] === $this->matrix[1][0]
            && $this->matrix[0][0] === $this->matrix[2][0]
            && $this->matrix[0][0] !== 0) { // horizontal
            return true;
        } elseif ( $this->matrix[0][1] === $this->matrix[1][1]
              && $this->matrix[0][1] === $this->matrix[2][1]
              && $this->matrix[0][1] !== 0) { // horizontal
            return true;
        } elseif ( $this->matrix[0][2] === $this->matrix[1][2]
              && $this->matrix[0][2] === $this->matrix[2][2]
              && $this->matrix[0][2] !== 0) { // horizontal
            return true;
        } elseif ( $this->matrix[0][0] === $this->matrix[0][1]
              && $this->matrix[0][0] === $this->matrix[0][2]
              && $this->matrix[0][0] !== 0) { // vertical
            return true;
        } elseif ( $this->matrix[1][0] === $this->matrix[1][1]
              && $this->matrix[1][0] === $this->matrix[1][2]
              && $this->matrix[1][0] !== 0) { // vertical
            return true;
        } elseif ( $this->matrix[2][0] === $this->matrix[2][1]
              && $this->matrix[2][0] === $this->matrix[2][2]
              && $this->matrix[2][0] !== 0) { // vertical
            return true;
        } elseif ( $this->matrix[0][0] === $this->matrix[1][1]
              && $this->matrix[0][0] === $this->matrix[2][2]
              && $this->matrix[0][0] !== 0) { // crossed
            return true;
        } elseif ( $this->matrix[0][2] === $this->matrix[1][1]
              && $this->matrix[0][2] === $this->matrix[2][0]
              && $this->matrix[0][2] !== 0) { // crossed
            return true;
        } else { // no win
            return false;
        }
    }

    public function getMatrix():array
    {
        return $this->matrix;
    }

    public function getPlayerChar():string
    {
        return $this->playerChar;
    }

    public function getComputerChar():string
    {
        return $this->computerChar;
    }

    public function getDifficulty():int
    {
        return $this->difficulty;
    }

}
