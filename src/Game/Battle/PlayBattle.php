<?php namespace Game\Battle;

class PlayBattle implements \Countable
{

    /**
     * @var array
     */
    private $gamers = [];

    /**
     * @var array
     */
    private $cards = [];

    /**
     * @var bool
     */
    private $isBattle = false;

    /**
     * @var int
     */
    private $bonus = 0;

    /**
     * @var int
     */
    private $hit = 0;

    public function __construct(array $cards, array $gamers)
    {
        $this->cards = $cards;
        $this->gamers = $gamers;

        $this->distribute();
    }

    protected function distribute()
    {
        $nbGamers = count($this->gamers);
        while (count($this->cards) >= $nbGamers) {
            foreach ($this->gamers as $gamer) {
                $gamer->setCard(array_shift($this->cards));
            }
        }
    }

    /**
     * @return mixed
     */
    public function getGamer($name)
    {
        foreach ($this->gamers as $gamer) {
            if ($name == $gamer->getName()) return $gamer;
        }

        throw new \InvalidArgumentException('no gamer exist');
    }

    /**
     * @param $name
     */
    public function setGamer($name)
    {
        $this->gamers[] = $name;
    }

    /**
     * @return string
     */
    public function battle()
    {
        if (count($this->gamers) != 2)
            throw new \InvalidArgumentException(sprintf('this game is for two player, number %d', count($this->gamers)));

        if ($this->isGameOver()) return;

        $this->winner($this->gamers[0], $this->gamers[1]);

        if ($this->isBattle) {
            $this->isBattle = false;
            $this->bonus += ((int)$this->gamers[0]->fire() + (int)$this->gamers[1]->fire());
            $this->battle();
        } else {
            $this->bonus = 0;
        }
    }

    /**
     * @param ...$gamers
     * @return string
     *
     * <pre>calculate the winner</pre>
     */
    protected function winner(...$gamers)
    {

        $gamer1 = $gamers[0];
        $gamer2 = $gamers[1];

        $power1 = $gamer1->fire();
        $power2 = $gamer2->fire();

        if (is_null($power1) || is_null($power2)) return;

        if ($power1 == $power2) {
            $this->bonus += $power1 + $power2;
            $this->isBattle = true;

            return;
        }

        $power = $power1 + $power2;

        if ($power1 > $power2) {
            $gamer1->setPower($power, $this->bonus);

            return;
        }

        $gamer2->setPower($power, $this->bonus);

        return;

    }

    /**
     * @description: run battle
     */
    public function run()
    {
        while (!$this->isGameOver()) {
            $this->battle();
            $this->hit++;
        }
    }

    protected function isGameOver()
    {
        if ($this->isBattle) {
            if (count($this->gamers[0]) <= 1
                || count($this->gamers[1]) <= 1
            )
                return true;
        }

        if (count($this->gamers[0]) == 0
            || count($this->gamers[1]) == 0
        )
            return true;

        return false;
    }

    public function count()
    {
        return $this->hit;
    }

}