<?php namespace Game\Battle;

use Game\Core\AbstractCard;

class Card extends AbstractCard
{

    /**
     * @var array value card
     */
    protected static $values = [null, null, 2, 3, 4, 5, 6, 7, 8, 9, 10, 'valet', 'dame', 'roi', 'as'];

    /**
     * @var array color
     */
    protected static $colors = ['coeur', 'carreau', 'trefle', 'pique'];

    /**
     * @var int
     */
    protected $value;

    /**
     * @var string
     */
    protected $color;

    public function __construct($value, $color)
    {
        if ($this->isValidCard($value, $color))
            throw new \InvalidArgumentException(sprintf('invalid value or color (%s, %s)', $value, $color));

        $this->value = $value;
        $this->color = $color;
    }

    public function __toString()
    {
        return 'value of card is: ' . self::$values[$this->value] . ' and color is: ' . self::$colors[$this->color];
    }

    /**
     * @param $value int
     * @param $color int
     */
    protected function isValidCard($value, $color)
    {
        if ($value < 2 || $value > 14) {
            throw new \InvalidArgumentException(sprintf('impossible offset value %d', $value));
        }

        if ($color < 0 || $color > 3) {
            throw new \InvalidArgumentException(sprintf('impossible offset color %d', $color));
        }
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * echo console render
     */
    public function render()
    {
        $card = (string)$this;
        $length = strlen($card);
        echo '/' . str_repeat('-', $length) . '\\' . "\n";
        echo '|' . str_repeat('-', $length) . '|' . "\n";
        echo '|' . $card . '|' . "\n";
        echo '|' . str_repeat('-', $length) . '|' . "\n";
        echo '\\' . str_repeat('-', $length) . '/' . "\n";

    }

}