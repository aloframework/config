<?php
/**
 *    Copyright (c) Arturas Molcanovas <a.molcanovas@gmail.com> 2016.
 *    https://github.com/aloframework/config
 *
 *    Licensed under the Apache License, Version 2.0 (the "License");
 *    you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *    Unless required by applicable law or agreed to in writing, software
 *    distributed under the License is distributed on an "AS IS" BASIS,
 *    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *    See the License for the specific language governing permissions and
 *    limitations under the License.
 */

namespace AloFramework\Config;

    /**
     * Indicates that the class can use the AbstractConfig template
     *
     * @author Art <a.molcanovas@gmail.com>
     */
    interface Configurable {

        /**
         * Adds an item to the configuration array
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         * @param mixed  $v Configuration item value
         *
         * @return self
         */
        public function addConfig($k, $v);

        /**
         * Removes an item from the configuration array.
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return bool True if the item existed in custom config, false if it didn't
         */
        public function removeConfig($k);

        /**
         * Returns a configuration item or null if it's not found
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return mixed
         */
        public function getConfig($k);

        /**
         * Returns all the configuration settings
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getFullConfig();

        /**
         * Returns the custom-set configuration
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getCustomConfig();

        /**
         * Returns the default configuration
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getDefaultConfig();
    }
