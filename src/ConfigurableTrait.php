<?php

    namespace AloFramework\Config;

    /**
     * A quick implementation of the Configurable interface
     * @author Art <a.molcanovas@gmail.com>
     */
    trait ConfigurableTrait {

        /**
         * The configuration holder
         * @var AbstractConfig
         */
        protected $config;

        /**
         * Adds an item to the configuration array
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         * @param mixed  $v Configuration item value
         *
         * @return self
         */
        function addConfig($k, $v) {
            $this->config->set($k, $v);

            return $this;
        }

        /**
         * Removes an item from the configuration array.
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return bool True if the item existed in custom config, false if it didn't
         */
        function removeConfig($k) {
            return $this->config->remove($k);
        }

        /**
         * Returns a configuration item or null if it's not found
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return mixed
         */
        function getConfig($k) {
            return $this->config->get($k);
        }

        /**
         * Returns all the configuration settings
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        function getFullConfig() {
            return $this->config->getAll();
        }

        /**
         * Returns the custom-set configuration
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        function getCustomConfig() {
            return $this->config->getCustomConfig();
        }

        /**
         * Returns the default configuration
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        function getDefaultConfig() {
            return $this->config->getDefaultConfig();
        }
    }
