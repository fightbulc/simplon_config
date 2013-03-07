<?php

  namespace Simplon\Config;

  class Config
  {
    /** @var Config */
    private static $_instance;

    /** @var string */
    private $_configPath;

    /** @var array */
    private $_config = array();

    // ########################################

    /**
     * @return static
     */
    final public static function getInstance()
    {
      if(! static::$_instance)
      {
        static::$_instance = new static();
      }

      return static::$_instance;
    }

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
     * @return string
     * @throws \Exception
     */
    public function getConfigPath()
    {
      $filePath = $this->_configPath;

      if(! file_exists($filePath))
      {
        throw new \Exception('Simplon/Config: Config file at "' . $filePath . '" doesnt exist.');
      }

      return $filePath;
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

        // get current environment
        $env = $app['environment'];

        // pull through appName and environment
        $app[$env]['environment'] = $env;
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
     * @return array
     * @throws \Exception
     */
    public function getConfigByKeys(array $keys)
    {
      $config = $this->getConfig();

      foreach($keys as $key)
      {
        if(! isset($config[$key]))
        {
          throw new \Exception('Simplon/Config: Config key "' . implode('->', $keys) . '" doesnt exist.');
        }

        $config = $config[$key];
      }

      return $config;
    }
  }
