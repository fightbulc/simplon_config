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
     * @return Config
     */
    public static function getInstance()
    {
      if(! isset(Config::$_instance))
      {
        Config::$_instance = new Config();
      }

      return Config::$_instance;
    }

    // ########################################

    /**
     * @param $path
     * @return Config
     */
    public function setConfigPath($path)
    {
      $this->getInstance()->_configPath = $path;

      return $this;
    }

    // ########################################

    /**
     * @return string
     * @throws \Exception
     */
    public function getConfigPath()
    {
      $filePath = $this->getInstance()->_configPath;

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
      if(! $this->getInstance()->_config)
      {
        $app = array();

        require $this
          ->getInstance()
          ->getConfigPath();

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
        $this->getInstance()->_config = $app[$env];
      }

      return $this->getInstance()->_config;
    }

    // ########################################

    /**
     * @param array $keys
     * @return mixed
     * @throws \Exception
     */
    public function getConfigByKeys(array $keys)
    {
      $config = $this
        ->getInstance()
        ->getConfig();

      foreach($keys as $key)
      {
        if(array_key_exists($key, $config))
        {
          $config = $config[$key];
        }
        else
        {
          throw new \Exception('Simplon/Config: Config key "' . implode('->', $keys) . '" doesnt exist.');
        }
      }

      return $config;
    }
  }
