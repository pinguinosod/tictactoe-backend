<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once('class-tictactoe.php');

final class TictactoeTest extends TestCase
{
    public function testInstantiate(): void
    {
        $ttt = new Tictactoe('x', Tictactoe::generateEmptyMatrix(), 3);

        $this->assertEquals($ttt->getPlayerChar(), 'x');

        $this->assertEquals($ttt->getComputerChar(), 'o');

        $this->assertEquals($ttt->getDifficulty(), 3);        
    }

    public function testGenerateEmptyMatrix(): void
    {
        $matrix = Tictactoe::generateEmptyMatrix();

        $this->assertCount(
            3,
            $matrix
        );

        $this->assertContainsOnly(
            "array",
            $matrix
        );

        $this->assertContainsOnly(
            "integer",
            $matrix[0]
        );

        $this->assertContainsOnly(
            "integer",
            $matrix[1]
        );

        $this->assertContainsOnly(
            "integer",
            $matrix[2]
        );
    }

    public function testMark(): void
    {
        $ttt = new Tictactoe('x', Tictactoe::generateEmptyMatrix());

        $ttt->mark(1, 1);

        $matrix = $ttt->getMatrix();

        $this->assertEquals($matrix[1][1], 'x');
    }

    public function testCheckWin(): void
    {
        $ttt = new Tictactoe('x', Tictactoe::generateEmptyMatrix(), 1);

        $this->assertFalse(
            $ttt->checkWin()
        );

        $ttt->mark(0,0);
        $ttt->mark(1,0);
        $ttt->mark(2,0);

        $this->assertTrue(
            $ttt->checkWin()
        );
    }
}