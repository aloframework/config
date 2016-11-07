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

    use AloFramework\Common\Alo;
    use ArrayAccess;
    use JsonSerializable;
    use Serializable;

    /**
     * The abstract configuration class
     *
     * @author Art <a.molcanovas@gmail.com>
     * @since  1.1 Implements JsonSerializable, Serializable
     */
    abstract class AbstractConfig implements ArrayAccess, JsonSerializable, Serializable {

        /**
         * Default configuration
         *
         * @var array
         */
        private $defaults;

        /**
         * Custom configuration
         *
         * @var array
         */
        private $custom;

        /**
         * Merged configuration
         *
         * @var array
         */
        private $merged;

        /**
         * End of line separator for __toString()
         *
         * @internal
         */
        const EOL = " \n";

        /**
         * Constructor
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param array $defaults The default configuration
         * @param array $custom   The custom/user-supplied configuration
         */
        public function __construct(array $defaults = [], array $custom = []) {
            $this->defaults = $defaults;
            $this->custom = $custom;
            $this->merge();
        }

        /**
         * Serializes the object
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return string
         * @since  1.1
         */
        public function serialize() {
            return serialize([$this->defaults, $this->custom]);
        }

        /**
         * Unserializes the object
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $serialized The serialised string
         *
         * @since  1.1
         */
        public function unserialize($serialized) {
            $s = unserialize($serialized);
            $this->defaults = $s[0];
            $this->custom = $s[1];
            $this->merge();
        }

        /**
         * Returns a json-encodable version of the object
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         * @since  1.1
         */
        public function jsonSerialize() {
            return $this->merged;
        }

        /**
         * Returns default configuration
         *
         * @return array
         */
        public function getDefaultConfig() {
            return $this->defaults;
        }

        /**
         * Returns custom-set configuration
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getCustomConfig() {
            return $this->custom;
        }

        /**
         * Merges the custom and default configurations
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @return self
         */
        private function merge() {
            $this->merged = array_merge($this->defaults, $this->custom);

            return $this;
        }

        /**
         * Sets a configuration key
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The config key
         * @param mixed  $v The config value
         *
         * @return self
         */
        public function set($k, $v) {
            $this->custom[$k] = $v;
            $this->merge();

            return $this;
        }

        /**
         * Sets a configuration key
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The config key
         * @param mixed  $v The config value
         *
         * @uses   AbstractConfig::set()
         */
        public function __set($k, $v) {
            $this->set($k, $v);
        }

        /**
         * Returns a configuration item or NULL if it's not set
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The configuration item key
         *
         * @return mixed
         */
        public function get($k) {
            return Alo::get($this->merged[$k]);
        }

        /**
         * Returns a configuration item or NULL if it's not set
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The configuration item key
         *
         * @return mixed
         * @uses   AbstractConfig::get()
         */
        public function __get($k) {
            return $this->get($k);
        }

        /**
         * Returns all the config items
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        public function getAll() {
            return $this->merged;
        }

        /**
         * Removes a custom configuration item
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The custom configuration item key
         *
         * @return bool TRUE if the key was present, false if it wasn't
         */
        public function remove($k) {
            if (array_key_exists($k, $this->custom)) {
                unset($this->custom[$k]);
                $this->merge();

                return true;
            }

            return false;
        }

        /**
         * Returns a string representation of the config
         *
         * @author Art <a.molcanovas@gmail.com>
         * @return string
         */
        public function __toString() {
            $r = '';

            foreach ($this->merged as $k => $v) {
                $r .= "$k \t => $v," . self::EOL;
            }

            $r = rtrim($r, ',' . self::EOL);

            return $r;
        }

        /**
         * Sets a custom config item
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string|int|null $offset The config item key
         * @param mixed           $value  The config item value
         */
        public function offsetSet($offset, $value) {
            if (is_null($offset)) {
                $this->custom[] = $value;
                $this->merge();
            } else {
                $this->set($offset, $value);
            }
        }

        /**
         * Checks if a merged config item exists
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param mixed $offset Config item key
         *
         * @return bool
         */
        public function offsetExists($offset) {
            return isset($this->merged[$offset]);
        }

        /**
         * Removes a custom config item key
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string|int $offset The config item key
         */
        public function offsetUnset($offset) {
            if (array_key_exists($offset, $this->custom)) {
                unset($this->custom[$offset]);
                $this->merge();
            }
        }

        /**
         * Returns a merged config item
         *
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string|int $offset The config item key
         *
         * @return mixed
         */
        public function offsetGet($offset) {
            return $this->get($offset);
        }
    }
