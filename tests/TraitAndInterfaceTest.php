<?php

    namespace AloFramework\Config;

    use PHPUnit_Framework_TestCase;

    class TraitAndInterfaceTestCustomConfig extends AbstractConfig {

        function __construct($custom = []) {
            parent::__construct(['one' => 'o',
                                 'two' => 't'],
                                $custom);
        }
    }

    class TraitAndInterfaceImplementor implements Configurable {

        use ConfigurableTrait;

        function __construct($cfg = []) {
            $this->config = new TraitAndInterfaceTestCustomConfig($cfg);
        }
    }

    class TraitAndInterfaceTest extends PHPUnit_Framework_TestCase {

        private static function getTheThing() {
            return new TraitAndInterfaceImplementor(['foo' => 'bar']);
        }

        function testGetFullConfig() {
            $this->assertEquals(['one' => 'o', 'two' => 't', 'foo' => 'bar'], self::getTheThing()->getFullConfig());
        }

        function testGetCustomConfig() {
            $this->assertEquals(['foo' => 'bar'], self::getTheThing()->getCustomConfig());
        }

        function testGetDefaultConfig() {
            $this->assertEquals(['one' => 'o', 'two' => 't'], self::getTheThing()->getDefaultConfig());
        }

        function testGetConfig() {
            $c = self::getTheThing();

            $this->assertEquals('o', $c->getConfig('one'));
            $this->assertEquals('t', $c->getConfig('two'));
            $this->assertEquals('bar', $c->getConfig('foo'));
        }

        function testAddConfig() {
            $obj = self::getTheThing();
            $raw = ['one' => 'o', 'two' => 't', 'foo' => 'bar'];

            $this->assertEquals($raw, $obj->getFullConfig());
            $this->assertTrue($obj->addConfig('my', 'var') instanceof TraitAndInterfaceImplementor);

            $this->assertEquals('var', $obj->getConfig('my'));
            $this->assertEquals(array_merge($raw, ['my' => 'var']), $obj->getFullConfig());
        }

        function testRemoveConfig() {
            $obj = self::getTheThing();
            $new = ['one' => 'o', 'two' => 't'];

            $this->assertEquals(['one' => 'o', 'two' => 't', 'foo' => 'bar'], $obj->getFullConfig());
            $this->assertTrue($obj->removeConfig('foo'));

            $this->assertEquals($new, $obj->getFullConfig());
            $this->assertFalse($obj->removeConfig('one'));
            $this->assertEquals($new, $obj->getFullConfig());
        }
    }
