<?php

if ( isset($_GET['x'], $_GET['y'], $_GET['matrix']) ) {
    $json = file_get_contents('https://phpinguino.herokuapp.com/tictactoe/?x='.intval($_GET['x']).'&y='.intval($_GET['y']).'&matrix='.$_GET['matrix']);
}
else {
    $json = file_get_contents('https://phpinguino.herokuapp.com/tictactoe/');
}

$json = json_decode($json);

$matrix = $json->matrix;
$x = $json->x ?? 1;
$y = $json->y ?? 1;
$winner = $json->winner;
$playerChar = strtoupper($json->player);
$computerChar = strtoupper($json->computer);

echo "<table>";
foreach (array_reverse($matrix) as $row) {
    echo "<tr>";
    foreach ($row as $cell) {
        echo "<td>";
        echo $cell === 0 ? '' : strtoupper($cell);
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";

$submitDisabled = '';
if ($winner) $submitDisabled = 'disabled';

?>

<style>
table {
    border-collapse: collapse;
    margin: 20px;
}
td {
    width: 40px;
    height: 40px;
    text-align: center;
    vertical-align: middle;
    font-size: 2.2rem;
}
td:nth-child(1), td:nth-child(2)  {
    border-right: 1px solid black;
}
tr:nth-child(1) > td, tr:nth-child(2) td {
    border-bottom: 1px solid black;
}
</style>

<p>
    Player: <?=$playerChar?><br>
    Computer: <?=$computerChar?><br>
    <form action='./play.php' method='get'>
        Enter coordinates:<br>
        x: <input type='number' min='1' max='3' name='x' value='<?=$x?>'>
        y: <input type='number' min='1' max='3' name='y' value='<?=$y?>'>
        <input type='hidden' name='matrix' value='<?=json_encode($matrix)?>'>
        <input type='submit' value='submit' <?=$submitDisabled?>>
    </form>
</p>

<?php
if ($winner) {
    echo "<p>Winner: ".$winner."</p>";
}
?>

<p>
    <form action='./play.php' method='get'>
        <input type='submit' value='reset'>
    </form>
</p>