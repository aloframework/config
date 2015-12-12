<?php

    namespace AloFramework\Config;

    use PHPUnit_Framework_TestCase;

    class AbstractConfigTestCustomConfig extends AbstractConfig {

    }

    class AbstractConfigTest extends PHPUnit_Framework_TestCase {

        private static $defaults = ['one' => 'foo',
                                    'two' => 'bar'];

        private static $custom = ['foo' => 'bar'];

        function testConstructDefault() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults);

            $this->assertEquals(self::$defaults, $c->getAll());
        }

        function testJsonSerialize() {
            $c   = new AbstractConfigTestCustomConfig(self::$defaults, self::$custom);
            $enc = json_encode($c);
            $this->assertEquals(json_encode(array_merge(self::$defaults, self::$custom)), $enc);
        }

        function testSerializeUnserialize() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults, self::$custom);
            /** @var AbstractConfigTestCustomConfig $cNew */
            $cNew = unserialize(serialize($c));

            $this->assertEquals($c, $cNew);
            $this->assertEquals($c->getDefaultConfig(), $cNew->getDefaultConfig());
            $this->assertEquals($c->getCustomConfig(), $cNew->getCustomConfig());
            $this->assertEquals($c->getAll(), $cNew->getAll());
        }

        function testGetDefaultAndCustomConfigs() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults, ['two' => 'buzz']);

            $this->assertEquals(self::$defaults, $c->getDefaultConfig());
            $this->assertEquals(['two' => 'buzz'], $c->getCustomConfig());
            $this->assertEquals(['one' => 'foo', 'two' => 'buzz'], $c->getAll());
        }

        function testConstructMerge() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults, self::$custom);

            $this->assertEquals(['one' => 'foo', 'two' => 'bar', 'foo' => 'bar'], $c->getAll());
        }

        function testConstructOverride() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults, ['foo' => 'bar', 'one' => 'one']);

            $this->assertEquals(['one' => 'one', 'two' => 'bar', 'foo' => 'bar'], $c->getAll());
        }

        /** @dataProvider settersProvider */
        function testSetters($k, $v) {
            $c1    = new AbstractConfigTestCustomConfig(self::$defaults);
            $c2    = new AbstractConfigTestCustomConfig(self::$defaults);
            $merge = array_merge(self::$defaults, [$k => $v]);

            $this->assertTrue($c1->set($k, $v) instanceof AbstractConfigTestCustomConfig);
            $this->assertEquals($merge, $c1->getAll());

            $c2->{$k} = $v;
            $this->assertEquals($merge, $c1->getAll());
        }

        function testRemove() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults, ['foo' => 'bar', 'one' => 'baz']);

            $this->assertEquals(['one' => 'baz', 'two' => 'bar', 'foo' => 'bar'], $c->getAll());

            $this->assertFalse($c->remove('iyisafugheqtq'));

            $this->assertTrue($c->remove('foo'));
            $this->assertEquals(['one' => 'baz', 'two' => 'bar'], $c->getAll());

            $this->assertTrue($c->remove('one'));
            $this->assertEquals(['one' => 'foo', 'two' => 'bar'], $c->getAll());
        }

        function testGetters() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults, self::$custom);

            $this->assertEquals('bar', $c->get('foo'));
            $this->assertEquals('foo', $c->get('one'));
            $this->assertEquals('bar', $c->get('two'));

            $this->assertEquals('bar', $c->foo);
            $this->assertEquals('foo', $c->one);
            $this->assertEquals('bar', $c->two);
        }

        function testToString() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults, self::$custom);

            $this->assertEquals("one \t => foo, \ntwo \t => bar, \nfoo \t => bar", $c->__toString());
        }

        function testArrayAccess() {
            $c = new AbstractConfigTestCustomConfig(self::$defaults);

            $this->assertEquals(self::$defaults, $c->getAll());
            $c['foo'] = 'bar';
            $this->assertEquals(array_merge(self::$defaults, ['foo' => 'bar']), $c->getAll());
            $this->assertEquals('bar', $c['foo']);
            $this->assertTrue(isset($c['foo']));

            unset($c['foo']);
            $this->assertEquals(self::$defaults, $c->getAll());
            $this->assertFalse(isset($c['foo']));

            $c[] = 'foo';
            $this->assertEquals('foo', $c[0]);
        }

        function settersProvider() {
            return [['one', 'one'],
                    ['foo', 'bar']];
        }
    }
