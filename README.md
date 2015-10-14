# AloFramework | Config #

A component that allows easy object configuration with default and overriding settings

Latest release API documentation: [https://aloframework.github.io/config/](https://aloframework.github.io/config/)

[![License](https://poser.pugx.org/aloframework/config/license?format=plastic)](https://www.gnu.org/licenses/gpl-3.0.en.html)
[![Latest Stable Version](https://poser.pugx.org/aloframework/config/v/stable?format=plastic)](https://packagist.org/packages/aloframework/config)
[![Total Downloads](https://poser.pugx.org/aloframework/config/downloads?format=plastic)](https://packagist.org/packages/aloframework/config)

|                                                                                         dev-develop                                                                                         |                                                                               Latest release                                                                               |
|:-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|
|                                [![Dev Build Status](https://travis-ci.org/aloframework/config.svg?branch=develop)](https://travis-ci.org/aloframework/config)                               |                      [![Release Build Status](https://travis-ci.org/aloframework/config.svg?branch=master)](https://travis-ci.org/aloframework/config)                     |
| [![SensioLabsInsight](https://insight.sensiolabs.com/projects/0cb6838a-c3bd-433a-81d0-ddea1aa4696d/mini.png)](https://insight.sensiolabs.com/projects/0cb6838a-c3bd-433a-81d0-ddea1aa4696d) |                    [![SensioLabsInsight](https://i.imgur.com/KygqLtf.png)](https://insight.sensiolabs.com/projects/0cb6838a-c3bd-433a-81d0-ddea1aa4696d)                   |
| [![Coverage Status](https://coveralls.io/repos/aloframework/config/badge.svg?branch=develop&service=github)](https://coveralls.io/github/aloframework/config?branch=develop)                | [![Coverage Status](https://coveralls.io/repos/aloframework/config/badge.svg?branch=master&service=github)](https://coveralls.io/github/aloframework/config?branch=master) |

## Installation ##

Installation is available via Composer:

    composer require aloframework/config

## The abstract class ##

`AloFramework\Config\AbstractConfig` is what your own library configurations should extend. It has three main private properties: `$defaults` holding default configuration, `$custom` holding custom configuration/overrides and `$merged`, which holds the actual configuration that will be used. Your overriding config class will populate the default array and accept any custom variables in the constructor, e.g.:

    use AloFramework\Config\AbstractConfig;

    class MyConfig extends AbstractConfig {

        private static $defaultConfig = ['foo'          => 'bar',
                                         'importantVar' => 'andItsValue'];

        function __construct($customConfig = []) {
            parent::__construct(self::$defaultConfig, $customConfig);
        }
    }

When reading the configuration, the values are fetched from the `$merged` array, which is essentially an `array_merge($this->defaults, $this->custom)`. For more information refer to the API documentation above.

## The interface ##

You can implement the `AloFramework\Config\Configurable` interface in your configuration-reading class to indicate that its runtime settings can be altered using this package. The trait described below can be used to implement the required methods.

## The trait ##

If you don't want to write your own methods you can simply include the provided `AloFramework\Config\ConfigurableTrait` which will implement all the methods required by the interface. 

## Updating the configuration ##

### Setting an item ###
You can add a custom configuration key or default setting override by calling `$config->set('myKey', 'myValue')`, using `__set()` like `$config->myKey = 'myValue'`, or simply using it like an array: `$config['myKey'] = 'myValue'`.

### Removing an item ###
You can remove **custom** configuration via `$config->remove('myKey')`, or by unsetting it like an array value: `unset($config['myKey']);`

## Reading the configuration ##

### Specific value ###
You can retrieve a specific configuration item from the merged array by calling `$config->get('myKey')`, using `__get()` like `$config->myKey` or by using the object like an array: `$config['myKey']`.

### The merged config ###
You can retrieve the merged array via `$config->getAll()`

### The default config ###

For this you would use `$config->getDefaultConfig()`

### The custom overrides ###

For this you would use `$config->getCustomConfig()`.
