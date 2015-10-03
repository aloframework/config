<?php

    namespace AloFramework\Config;

    use PHPUnit_Framework_TestCase;

    class CustomConfig extends AbstractConfig {

    }

    class AbstractConfigTest extends PHPUnit_Framework_TestCase {

        private static $defaults = ['one' => 'foo',
                                    'two' => 'bar'];

        private static $custom = ['foo' => 'bar'];

        function testConstructDefault() {
            $c = new CustomConfig(self::$defaults);

            $this->assertEquals(self::$defaults, $c->getAll());
        }

        function testConstructMerge() {
            $c = new CustomConfig(self::$defaults, self::$custom);

            $this->assertEquals(['one' => 'foo', 'two' => 'bar', 'foo' => 'bar'], $c->getAll());
        }

        function testConstructOverride() {
            $c = new CustomConfig(self::$defaults, ['foo' => 'bar', 'one' => 'one']);

            $this->assertEquals(['one' => 'one', 'two' => 'bar', 'foo' => 'bar'], $c->getAll());
        }

        /** @dataProvider settersProvider */
        function testSetters($k, $v) {
            $c1    = new CustomConfig(self::$defaults);
            $c2    = new CustomConfig(self::$defaults);
            $merge = array_merge(self::$defaults, [$k => $v]);

            $this->assertTrue($c1->set($k, $v) instanceof CustomConfig);
            $this->assertEquals($merge, $c1->getAll());

            $c2->{$k} = $v;
            $this->assertEquals($merge, $c1->getAll());
        }

        function testRemove() {
            $c = new CustomConfig(self::$defaults, ['foo' => 'bar', 'one' => 'baz']);

            $this->assertEquals(['one' => 'baz', 'two' => 'bar', 'foo' => 'bar'], $c->getAll());

            $this->assertFalse($c->remove('iyisafugheqtq'));

            $this->assertTrue($c->remove('foo'));
            $this->assertEquals(['one' => 'baz', 'two' => 'bar'], $c->getAll());

            $this->assertTrue($c->remove('one'));
            $this->assertEquals(['one' => 'foo', 'two' => 'bar'], $c->getAll());
        }

        function testGetters() {
            $c = new CustomConfig(self::$defaults, self::$custom);

            $this->assertEquals('bar', $c->get('foo'));
            $this->assertEquals('foo', $c->get('one'));
            $this->assertEquals('bar', $c->get('two'));

            $this->assertEquals('bar', $c->foo);
            $this->assertEquals('foo', $c->one);
            $this->assertEquals('bar', $c->two);
        }

        function testToString() {
            $c = new CustomConfig(self::$defaults, self::$custom);

            $this->assertEquals("one \t => foo, \ntwo \t => bar, \nfoo \t => bar", $c->__toString());
        }

        function settersProvider() {
            return [['one', 'one'],
                    ['foo', 'bar']];
        }
    }
