<?php

    namespace AloFramework\Config;

    use AloFramework\Common\Alo;

    /**
     * The abstract configuration class
     * @author Art <a.molcanovas@gmail.com>
     */
    abstract class AbstractConfig {

        /**
         * Default configuration
         * @var array
         */
        private $defaults;

        /**
         * Custom configuration
         * @var array
         */
        private $custom;

        /**
         * Merged configuration
         * @var array
         */
        private $merged;

        /**
         * End of line separator for __toString()
         * @internal
         */
        const EOL = " \n";

        /**
         * Constructor
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param array $defaults The default configuration
         * @param array $custom   The custom/user-supplied configuration
         */
        function __construct(array $defaults = [], array $custom = []) {
            $this->defaults = $defaults;
            $this->custom   = $custom;
            $this->merge();
        }

        /**
         * Merges the custom and default configurations
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
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The config key
         * @param mixed  $v The config value
         *
         * @return self
         */
        function set($k, $v) {
            $this->custom[$k] = $v;
            $this->merge();

            return $this;
        }

        /**
         * Sets a configuration key
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The config key
         * @param mixed  $v The config value
         *
         * @return self
         * @uses   AbstractConfig::set()
         */
        function __set($k, $v) {
            $this->set($k, $v);
        }

        /**
         * Returns a configuration item or NULL if it's not set
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The configuration item key
         *
         * @return mixed
         */
        function get($k) {
            return Alo::get($this->merged[$k]);
        }

        /**
         * Returns a configuration item or NULL if it's not set
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The configuration item key
         *
         * @return mixed
         * @uses   AbstractConfig::get()
         */
        function __get($k) {
            return $this->get($k);
        }

        /**
         * Returns all the config items
         * @author Art <a.molcanovas@gmail.com>
         * @return array
         */
        function getAll() {
            return $this->merged;
        }

        /**
         * Removes a custom configuration item
         * @author Art <a.molcanovas@gmail.com>
         *
         * @param string $k The custom configuration item key
         *
         * @return bool TRUE if the key was present, false if it wasn't
         */
        function remove($k) {
            if (array_key_exists($k, $this->custom)) {
                unset($this->custom[$k]);
                $this->merge();

                return true;
            }

            return false;
        }

        /**
         * Returns a string representation of the config
         * @author Art <a.molcanovas@gmail.com>
         * @return string
         */
        function __toString() {
            $r = '';

            foreach ($this->merged as $k => $v) {
                $r .= "$k \t => $v," . self::EOL;
            }

            $r = rtrim($r, ',' . self::EOL);

            return $r;
        }
    }
