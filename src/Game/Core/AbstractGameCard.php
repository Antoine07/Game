<?php namespace Game\Core;

abstract class AbstractGameCard
{
    protected $cards = [];
    protected $max = 52;

    abstract public function initialize($empty = true);
    abstract public function setCard($card);
    abstract protected function make();

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    public function shuffle()
    {
        shuffle($this->cards);
    }

    public function __toString()
    {
        return implode(', ', $this->cards);
    }

    public function draw()
    {
        $card = array_pop($this->cards);
        if (!isset($card)) return;

        return (string)$card;
    }

    protected function isCardInDeck(Card $card)
    {
        foreach ($this->cards as $c) {
            if ($c->getColor() == $card->getColor()
                && $c->getValue() == $card->getValue()
            ) return true;
        }

        return false;
    }
}