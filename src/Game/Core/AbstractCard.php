<?php namespace Game\Core;

abstract class AbstractCard
{

    protected static $values = null;
    protected static $colors = null;
    protected $value;
    protected $color;

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

    abstract protected function isValidCard($value, $color);

    abstract public function __toString();
}