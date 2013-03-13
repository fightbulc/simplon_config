<pre>
     _                 _                                __ _       
 ___(_)_ __ ___  _ __ | | ___  _ __     ___ ___  _ __  / _(_) __ _ 
/ __| | '_ ` _ \| '_ \| |/ _ \| '_ \   / __/ _ \| '_ \| |_| |/ _` |
\__ \ | | | | | | |_) | | (_) | | | | | (_| (_) | | | |  _| | (_| |
|___/_|_| |_| |_| .__/|_|\___/|_| |_|  \___\___/|_| |_|_| |_|\__, |
                |_|                                          |___/ 
</pre>

# Simplon Config

Its a simple config file reader which handles namespaced config arrays.

## Config file example

```php
$app = [
  'appName'     => 'service.store',
  'environment' => 'local',
];

// ##########################################
// environment: local

$app['local'] = [
  'url'      => [
    'domain'   => 'http://local.jag.store.stage-service',
    'frontend' => 'http://local.jag.store.stage-web',
    'public'   => '',
  ],
  'path'     => [
    'games' => __DIR__ . '/../games',
  ],
  'database' => [
    'mysql' => [
      [
        'server'   => 'localhost',
        'database' => 'jag_store_stage',
        'username' => 'rootuser',
        'password' => 'rootuser'
      ]
    ],
  ],
  'email'    => [
    'host' => 'localhost',
    'port' => 25,
  ],
  'vars'     => [
    'allowedSessionMinutes' => 0,
  ],
];

// ##########################################
// environment: stage

$app['stage'] = [];

// ##########################################
// environment: production

$app['production'] = [];
```

This type of config file enables us to maintain one file for as many different environments as the application requires. The active environment is enabled via the array entry ```$app['environment'] = 'XXX'```.

## Get data from your config file

To safe resources we access the config class via singleton pattern ```Config::getInstance()```. By passing the config file path we inform the class which file we want to read. Now, in order to fetch an actual value we pass an existing config array index as array to ```getConfigKeys(['url'])```. As a result we would receive all values which are within the array index of ```url```:

```php
[
  'domain'   => 'http://local.jag.store.stage-service',
  'frontend' => 'http://local.jag.store.stage-web',
  'public'   => '',
];
```

Multiple array elements will be chained together. According to that the following example will only return the string value for ```['url']['domain']```:

```php
use Simplon\Config\Config;

$configPath = __DIR__ . '/../../config/common.config.php';

$urlDomain = Config::getInstance()
->setConfigPath($configPath)
->getConfigByKeys(['url', 'domain']);

echo $urlDomain; // prints "http://local.jag.store.stage-service"
```