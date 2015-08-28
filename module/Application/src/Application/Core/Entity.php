<?php
namespace Application\Core;

class Entity
{

    public function __get($var)
    {
        if (property_exists($this, $var)) {
            return $this->{$var};
        }
        return null;
    }

    public function __set($var, $value)
    {
        if (property_exists($this, $var)) {
            return $this->{$var} = $value;
        }
    }

}