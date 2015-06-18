<?php namespace Game\Battle;

class Gamer implements \Countable
{

    /**
     * @var
     */
    protected $name;

    /**
     * @var int
     */
    protected $power = 0;

    /**
     * @var array
     */
    protected $cards = [];

    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->cards;
    }

    /**
     * @param mixed $cards
     */
    public function setCard(Card $cards)
    {
        $this->cards[] = $cards;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * @param $power
     * @param int $bonus
     */
    public function setPower($power, $bonus = 0)
    {
        $this->power += (int)$power + (int)$bonus;
    }

    /**
     * @return null | int
     */
    public function fire()
    {
        if (empty($this->cards)) return;

        $card = array_shift($this->cards);

        return (int)$card->getValue();

    }

    /**
     * @return int
     * <pre> number of cards </pre>
     */
    public function count()
    {
        return count($this->cards);
    }

}