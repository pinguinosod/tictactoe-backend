<?php

require_once('class-tictactoe.php');

if ( isset($_GET['matrix']) ) {
    $matrix = json_decode($_GET['matrix']);
}
else {
    $matrix = Tictactoe::generateEmptyMatrix();
}

$ttt = new Tictactoe( 'x', $matrix );

$winner = 'noone';

$x = $y = 0;

if ( isset($_GET['x'], $_GET['y']) ) {
    $x = intval( $_GET['x'] );
    $y = intval( $_GET['y'] );

    if (!$ttt->checkWin()) { // if the game isn't finished already

        if ($ttt->mark( $x, $y )) { // mark a position by player (returns true if everything went ok)

            if ($ttt->checkWin()) { // player won
                $winner = 'player';
            }
            else {
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
                'matrix' => $ttt->getMatrix(),
                'winner'=> $winner 
            ];

echo '<pre>'.json_encode($result, JSON_PRETTY_PRINT).'</pre>';

?>

<form action='./' method='get'>
    <input type='number' min='0' max='2' name='x' value='<?=$x?>'>
    <input type='number' min='0' max='2' name='y' value='<?=$y?>'>
    <input type='hidden' name='matrix' value='<?=json_encode($ttt->getMatrix())?>'>
    <input type='submit' value='submit'>
</form>

<form action='./' method='get'>
    <input type='submit' value='reset'>
</form>
