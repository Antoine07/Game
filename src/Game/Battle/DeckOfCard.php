<?php namespace Game\Battle;

use Game\Core\AbstractGameCard;

class DeckOfCard extends AbstractGameCard implements \Countable
{

    /**
     * @param bool $empty
     * <pre>build play if false</pre>
     */
    public function initialize($empty = true)
    {
        ($empty) ?: $this->make();
    }

    /**
     * @param Card $card
     */
    public function setCard($card)
    {
        if ($this->isCardInDeck($card)) throw new \RuntimeException(sprintf('this card exist into package...%s', (string)$card));

        $this->cards[] = $card;
    }

    protected function make()
    {
        foreach (range(2, 14) as $value) {
            foreach (range(0, 3) as $color) {
                $this->cards[] = (new Card($value, $color));
            }
        }
    }

    /**
     * @param Card $card
     */
    public function add(Card $card)
    {
        if (count($this->cards) != $this->max)
            $this->setCard($card);
    }

    public function count()
    {
        return count($this->cards);
    }

}