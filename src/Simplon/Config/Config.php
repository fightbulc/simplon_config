<?php

    namespace Simplon\Config;

    class Config
    {
        /** @var Config */
        private static $_instance;

        /** @var string */
        private $_configPath;

        /** @var array */
        private $_config = [];

        // ########################################

        /**
         * @return static
         */
        final public static function getInstance()
        {
            if (!static::$_instance)
            {
                static::$_instance = new static();
            }

            return static::$_instance;
        }

        // ########################################

        /**
         * @param $path
         *
         * @return $this
         */
        public function setConfigPath($path)
        {
            $this->_configPath = $path;

            return $this;
        }

        // ########################################

        /**
         * @return string
         * @throws \Exception
         */
        public function getConfigPath()
        {
            if (!file_exists($this->_configPath))
            {
                throw new \Exception('Simplon/Config: Config file at "' . $this->_configPath . '" doesnt exist.');
            }

            return $this->_configPath;
        }

        // ########################################

        /**
         * @return array
         */
        public function getConfig()
        {
            if (!$this->_config)
            {
                $app = [];

                require $this->getConfigPath();

                $this->_config = $app;
            }

            return $this->_config;
        }

        // ########################################

        /**
         * @param array $keys
         *
         * @return array
         * @throws \Exception
         */
        public function getConfigByKeys(array $keys)
        {
            $config = $this->getConfig();

            foreach ($keys as $key)
            {
                if (!isset($config[$key]))
                {
                    throw new \Exception('Simplon/Config: Config key "' . implode('->', $keys) . '" doesnt exist.');
                }

                $config = $config[$key];
            }

            return $config;
        }
    }
