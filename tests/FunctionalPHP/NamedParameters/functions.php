<?php

namespace tests\units;

use atoum;
use FunctionalPHP\NamedParameters as NP;

require_once __DIR__.'/../../../src/functions.php';

class Test {
    public $value;

    public function __construct($a, $b, $c, $d) {
        $this->value = [$a, $b, $c, $d];
    }
}

class stdClass extends atoum
{
    /** @dataProvider constructDataProvider */
    public function testConstruct($value)
    {
        $instance = NP\construct(Test::class, $value);
        $this->variable($instance->value)->isIdenticalTo(array_values($value));
    }

    public function constructDataProvider()
    {
        return [
            [[1, 2, 3, 4]],
            [['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4]],
        ];
    }

    /** @dataProvider simpleDataProvider */
    public function testNonAssociative(callable $callable, array $data, array $expected)
    {
        $this->variable(NP\call_user_func_array_np($callable, array_values($data)))
            ->isIdenticalTo($expected);
    }

    /** @dataProvider simpleDataProvider */
    public function testAssociative(callable $callable, array $data, array $expected)
    {
        $this->variable(NP\call_user_func_array_np($callable, $data))
            ->isIdenticalTo($expected);
    }

    /** @dataProvider simpleDataProvider */
    public function testReversed(callable $callable, array $data, array $expected)
    {
        $this->variable(NP\call_user_func_array_np($callable, array_reverse($data)))
            ->isIdenticalTo($expected);
    }

    /** @dataProvider simpleDataProvider */
    public function testShuffled(callable $callable, array $data, array $expected)
    {
        $keys = array_keys($data);
        shuffle($keys);

        $copy = [];
        foreach($keys as $key) {
            $copy[$key] = $data[$key];
        }

        $this->variable(NP\call_user_func_array_np($callable, $copy))
            ->isIdenticalTo($expected);
    }

    public function simpleDataProvider()
    {
        return [
            [
                function($a) { return [$a]; },
                ['a' => 1],
                [1]
            ],
            [
                function($a, $b, $c, $d) { return [$a, $b, $c, $d]; },
                ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
                [1, 2, 3, 4]
            ],
            [
                function($a, $b, $c, $d) { return [$a, $b, $c, $d]; },
                ['a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd'],
                ['a', 'b', 'c', 'd'],
            ],
        ];
    }
}
