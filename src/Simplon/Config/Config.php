<?php

  namespace Simplon\Config;

  class Config
  {
    /** @var string */
    private static $_configPath;

    /**
     * @var array
     */
    private static $_config = array();

    // ########################################

    /**
     * @param $path
     * @return Config
     */
    public static function setConfigPath($path)
    {
      Config::$_configPath = $path;
    }

    // ########################################

    /**
     * @return string
     * @throws \Exception
     */
    public static function getConfigPath()
    {
      $filePath = Config::$_configPath;

      if(!file_exists($filePath))
      {
        throw new \Exception('Simplon/Config: Config file at "' . $filePath . '" doesnt exist.');
      }

      return $filePath;
    }

    // ########################################

    /**
     * @return array
     */
    public static function getConfig()
    {
      if(! Config::$_config)
      {
        $app = array();

        require Config::getConfigPath();

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
        Config::$_config = $app[$env];
      }

      return Config::$_config;
    }

    // ########################################

    /**
     * @param array $keys
     * @return mixed
     * @throws \Exception
     */
    public static function getConfigByKeys(array $keys)
    {
      $config = Config::getConfig();

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
