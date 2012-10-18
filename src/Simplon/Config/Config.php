<?php

  namespace Simplon\Config;

  class Config
  {
    private $_configPath;

    /**
     * @var array
     */
    protected $_config = array();

    // ########################################

    /**
     * @param $path
     * @return Config
     */
    public function setConfigPath($path)
    {
      $this->_configPath = $path;

      return $this;
    }

    // ########################################

    /**
     * @return mixed
     */
    public function getConfigPath()
    {
      return $this->_configPath;
    }

    // ########################################

    /**
     * @return array
     */
    public function getConfig()
    {
      if(! $this->_config)
      {
        $app = array();

        require $this->getConfigPath();

        /**
         * get current environment
         */
        $env = $app['environment'];

        /**
         * insert appName in environment
         */
        $app[$env]['appName'] = $app['appName'];

        /**
         * only enabled environment
         */
        $this->_config = $app[$env];
      }

      return $this->_config;
    }

    // ########################################

    /**
     * @param array $keys
     * @return mixed
     * @throws \Exception
     */
    public function getConfigByKeys(array $keys)
    {
      $config = $this->getConfig();

      foreach($keys as $key)
      {
        if(array_key_exists($key, $config))
        {
          $config = $config[$key];
        }
        else
        {
          throw new \Exception('Config key "' . implode('->', $keys) . '" doesnt exist.');
        }
      }

      return $config;
    }
  }
