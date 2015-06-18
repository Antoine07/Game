<?php

use \Game\Battle\DeckOfCard;
use \Game\Battle\Gamer;
use \Game\Battle\PlayBattle;
use \Game\Battle\Card;


class BattleTest extends PHPUnit_Framework_TestCase
{

    protected $game;
    protected $gamers;
    protected $battle;

    public function setUp()
    {
        $this->game = new DeckOfCard();
        $this->game->initialize(false);
        $this->game->shuffle();

        $this->gamers[] = new Gamer('Tony');
        $this->gamers[] = new Gamer('Fenley');
        $this->battle = new PlayBattle($this->game->getCards(), $this->gamers);
    }

    /**
     * @test 52 cards
     */
    public function testPackage()
    {
        $this->assertEquals(52, count($this->game));
    }

    /**
     * @test
     */
    public function testCreateGamers()
    {

        $tony = $this->battle->getGamer('Tony');
        $fenley = $this->battle->getGamer('Fenley');

        $this->assertEquals('Tony', $tony->getName());
        $this->assertEquals('Fenley', $fenley->getName());

    }

    /**
     * @test distribute 52 cards to both players
     */
    public function testDistribute()
    {
        $tony = $this->battle->getGamer('Tony');
        $fenley = $this->battle->getGamer('Fenley');

        $this->assertEquals(26, count($fenley->getCard()));
        $this->assertEquals(26, count($tony->getCard()));
    }

    /**
     * @test play as long as there has cards
     */
    public function testFire()
    {
        $tony = $this->battle->getGamer('Tony');
        $compt = 3;

        while ($compt > 0) {
            $tony->fire();
            $compt--;
        }
        $this->assertEquals(23, count($tony->getCard()));
    }

    /**
     * @test power set
     */
    public function testSetPowerGamer()
    {

        $card1 = new Card(3, 2);
        $card2 = new Card(2, 3);

        $tony = new Gamer('Tony');
        $tony->setCard($card1);
        $tony->setCard($card2);

        $bonus = $tony->fire();
        $bonus += $tony->fire();

        $tony->setPower(2, $bonus);
        $tony->setPower(5);
        $tony->setPower(11);

        $this->assertEquals(23, $tony->getPower());
    }

    /**
     * @test if the battle is true
     */
    public function testBattle()
    {

        $tony = new Gamer('Tony');
        $fenley = new Gamer('Fenley');

        $cards = array_map(function ($data) {

            return new Card($data[0], $data[1]);

        }, [[3, 2], [3, 3], [2, 3], [4, 3], [4, 1], [4, 2], [11, 3], [9, 3], [10, 3], [7, 3]]);

        $battle = new PlayBattle($cards, [$tony, $fenley]);

        $this->assertEquals(5, count($tony->getCard()));
        $this->assertEquals(5, count($fenley->getCard()));

        $battle->battle();

        $this->assertEquals(57, $tony->getPower());
        $this->assertEquals(0, $fenley->getPower());

    }

    /**
     * @test the result must be a number and no more cards in the game
     */
    public function testResult()
    {
        while (count($this->gamers[0]) > 0 && count($this->gamers[1]) > 0) {
            $this->battle->battle();
        }

        $this->assertTrue(
            ($this->gamers[0]->getPower() > $this->gamers[1]->getPower())
            || ($this->gamers[1]->getPower() > $this->gamers[0]->getPower())
        );

        $this->assertEquals(0, count($this->gamers[0]));
        $this->assertEquals(0, count($this->gamers[1]));
    }

}