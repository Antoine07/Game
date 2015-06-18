<?php
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;

use Game\Battle\DeckOfCard;
use Game\Battle\PlayBattle;
use Game\Battle\Gamer;
use Game\Battle\Card;

class GameContext implements Context, SnippetAcceptingContext
{

    protected $game;
    protected $gamers = [];
    protected $battle;
    protected $cards;

    /**
     * @Given An game with no card
     */
    public function anGameWithNoCard()
    {
        $this->game = new DeckOfCard();
        $this->game->initialize(true);

        if (count($this->game) != 0) throw new PendingException();
    }

    /**
     * @Given two players :arg1 and :arg2
     */
    public function twoPlayersAnd($arg1, $arg2)
    {

        $this->gamers[] = new Gamer($arg1);
        $this->gamers[] = new Gamer($arg2);

    }

    /**
     * @Then The game can be started the cards are distributed
     */
    public function theGameCanBeStartedTheCardsAreDistributed()
    {

        $this->battle = new PlayBattle($this->game->getCards(), $this->gamers);

    }

    /**
     * @Given I have  (:arg1) and (:arg2)
     */
    public function iHaveAnd($arg1, $arg2)
    {
        $arg1 = explode(',', $arg1);
        $arg2 = explode(',', $arg2);

        $this->cards[] = new Card($arg1[0], $arg1[1]);
        $this->cards[] = new Card($arg2[0], $arg2[1]);

    }

    /**
     * @When I add (:arg1, :arg2) the first card to Tony and seconde one to Fenley
     */
    public function iAddTheFirstCardToTonyAndSecondeOneToFenley($arg1, $arg2)
    {
        $gamers[] = new Gamer($arg1);
        $gamers[] = new Gamer($arg2);

        $this->battle = new PlayBattle($this->cards, $gamers);

    }

    /**
     * @Then then winner is :arg1
     */
    public function thenWinnerIs($arg1)
    {

        $this->battle->battle();

        $gamers = ['Tony' => 'Tony', 'Fenley' => 'Fenley'];
        $winner = $gamers[$arg1];
        unset($gamers[$arg1]);

        $looser = array_shift($gamers);

        $winner = $this->battle->getGamer($winner);
        $looser = $this->battle->getGamer($looser);

        $this->battle->run();

        if ($winner->getPower() < $looser->getPower()) throw new Exception(sprintf('is wrong the winner is not %s', $winner));
    }

    /**
     * @Given the following cards for Tony:
     */
    public function theFollowingCardsForTony(TableNode $table)
    {
        foreach ($table as $card) {
            $card = explode(',', $card);
            $this->cards[] = new Card($card[0], $card[1]);
        }
    }

    /**
     * @Given the following cards:
     */
    public function theFollowingCards(TableNode $table)
    {
        foreach ($table as $row) {
            $row = explode(',', $row['card']);
            $cards[] = new Card((int)$row[0], (int)$row[1]);
        }

        $gamers[] = new Gamer('Tony');
        $gamers[] = new Gamer('Fenley');

        $this->battle = new PlayBattle($cards, $gamers);

    }

    /**
     * @Then the winner is Tony and total power is :arg1
     */
    public function theWinnerIsTonyAndTotalPowerIs($arg1)
    {
        $tony = $this->battle->getGamer('Tony');
        $fenley = $this->battle->getGamer('Fenley');

        $this->battle->battle();

        if ($arg1 != $tony->getPower()) throw new Exception('is wrong the winner is not Tony');

        if ($tony->getPower() < $fenley->getPower()) throw new Exception('is wrong the winner is not Tony');
    }

    /**
     * @Given the following cards to run battle:
     */
    public function theFollowingCardsToRunBattle(TableNode $table)
    {
        foreach ($table as $row) {
            $row = explode(',', $row['card']);
            $cards[] = new Card((int)$row[0], (int)$row[1]);
        }

        $gamers[] = new Gamer('Tony');
        $gamers[] = new Gamer('Fenley');

        $this->battle = new PlayBattle($cards, $gamers);

    }

    /**
     * @Then the winner is Tony and total power is :arg1 and Fenley power is :arg2
     */
    public function theWinnerIsTonyAndTotalPowerIsAndFenleyPowerIs($arg1, $arg2)
    {
        $tony = $this->battle->getGamer('Tony');
        $fenley = $this->battle->getGamer('Fenley');

        $this->battle->run();

        if ($arg1 != $tony->getPower() || $arg2 != $fenley->getPower()) throw new Exception('is wrong the winner is not Tony');

        if ($tony->getPower() < $fenley->getPower()) throw new Exception('is wrong the winner is not Tony');
    }

    /**
     * @Given the cards for two players
     */
    public function theCardsForTwoPlayers()
    {
        $cards = new DeckOfCard();
        $cards->initialize(false);
        $cards->shuffle();

        $gamers[] = new Gamer('Tony');
        $gamers[] = new Gamer('Fenley');

        $this->battle = new PlayBattle($cards->getCards(), $gamers);

        if ($count = count($cards->getCards()) != 52) throw new Exception(sprint('the number of card is not 52 but %s', $count));
    }

    /**
     * @When there are no cards the game stop the winner is one of two players
     */
    public function thereAreNoCardsTheGameStopTheWinnerIsOneOfTwoPlayers()
    {

        $tony = $this->battle->getGamer('Tony');
        $fenley = $this->battle->getGamer('Fenley');

        $powerMaxTony = 0; $powerMaxFenley = 0 ;

        foreach( $tony->getCard() as $card) $powerMaxTony += $card->getValue();
        foreach( $fenley->getCard() as $card) $powerMaxFenley += $card->getValue();

        $this->battle->run();

        $total = ($fenley->getPower() + $tony->getPower());

        $winner = $fenley->getPower() > $tony->getPower() ? 'Fenley' : 'Tony';

        if (($total > $powerMaxTony + $powerMaxFenley)) throw new Exception(sprint('impossible test to play full party %s', $total));

        echo "the winner is $winner with score for Tony {$tony->getPower()} and for Fenley {$fenley->getPower()}";

    }
}