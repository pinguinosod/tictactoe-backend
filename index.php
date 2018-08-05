<?php

header('Content-Type: application/json');

require_once('class-tictactoe.php');

if (isset($_GET['matrix'])) {
    $matrix = json_decode($_GET['matrix']);
} else {
    $matrix = Tictactoe::generateEmptyMatrix();
}

$difficulty = 2;
if (isset($_GET['d'])) {
    $difficulty = intval($_GET['d']);
}

$ttt = new Tictactoe('x', $matrix, $difficulty);

$winner = null;

$x = $y = null;

if (isset($_GET['x'], $_GET['y'])) {
    $x = intval($_GET['x']) - 1;
    $y = intval($_GET['y']) - 1;

    if (!$ttt->checkWin()) { // if the game isn't finished already

        if ($ttt->mark($x, $y)) { // mark a position by player (returns true if everything went ok)

            if ($ttt->checkWin()) { // player won
                $winner = 'player';
            } else {
                $ttt->computerMark(); // mark a position by computer
        
                if ($ttt->checkWin()) { // computer won
                    $winner = 'computer';
                }
            }
    
        }

    }
}

$result =   [ 
                'player' => $ttt->getPlayerChar(),
                'computer' => $ttt->getComputerChar(),
                'x' => $x + 1,
                'y' => $y + 1,
                'matrix' => $ttt->getMatrix(),
                'winner'=> $winner,
                'difficulty' => $ttt->getDifficulty()
            ];

echo json_encode($result, JSON_PRETTY_PRINT);
