<?php

    namespace AloFramework\Config;

    /**
     * Indicates that the class can use the AbstractConfig template
     * @author Art <a.molcanovas@gmail.com>
     */
    interface Configurable {

        /**
         * Adds an item to the configuration array
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         * @param mixed  $v Configuration item value
         *
         * @return self
         */
        function addConfig($k, $v);

        /**
         * Removes an item from the configuration array.
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return bool True if the item existed in custom config, false if it didn't
         */
        function removeConfig($k);

        /**
         * Returns a configuration item or null if it's not found
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return mixed
         */
        function getConfig($k);

        /**
         * Returns all the configuration settings
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        function getFullConfig();

        /**
         * Returns the custom-set configuration
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        function getCustomConfig();

        /**
         * Returns the default configuration
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        function getDefaultConfig();
    }
