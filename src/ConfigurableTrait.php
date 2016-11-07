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
     * A quick implementation of the Configurable interface
     *
     * @author Art <a.molcanovas@gmail.com>
     */
    trait ConfigurableTrait {

        /**
         * The configuration holder
         *
         * @var AbstractConfig
         */
        protected $config;

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
        public function addConfig($k, $v) {
            $this->config->set($k, $v);

            return $this;
        }

        /**
         * Removes an item from the configuration array.
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return bool True if the item existed in custom config, false if it didn't
         */
        public function removeConfig($k) {
            return $this->config->remove($k);
        }

        /**
         * Returns a configuration item or null if it's not found
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k Configuration item key
         *
         * @return mixed
         */
        public function getConfig($k) {
            return $this->config->get($k);
        }

        /**
         * Returns all the configuration settings
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getFullConfig() {
            return $this->config->getAll();
        }

        /**
         * Returns the custom-set configuration
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getCustomConfig() {
            return $this->config->getCustomConfig();
        }

        /**
         * Returns the default configuration
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getDefaultConfig() {
            return $this->config->getDefaultConfig();
        }
    }
