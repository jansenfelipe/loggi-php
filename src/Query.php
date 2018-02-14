<?php

namespace JansenFelipe\LoggiPHP;

class Query
{
    /**
     * @var array
     */
    private $value = [];

    /**
     * Query constructor.
     * @param array $value
     */
    function __construct(array $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return 'query ' . $this->parse($this->value);
    }

    private function parse(array $array = [])
    {
        $return = '{ ';

        foreach ($array as $key => $value) {

            if(!is_int($key))
                $return .= $key . ' ';

            if(is_array($value))
                $value = $this->parse($value);

            $return .= $value .  ' ';
        }

        $return .= ' }';

        return $return;
    }
}