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
  'url'      => [
    'service'  => '[URL_SERVICE]',
    'frontend' => '[URL_FRONTEND]',
  ],

  'database' => [
    'mysql' => [
      'localhost' => [
        'server'   => 'localhost',
        'database' => 'some_db',
        'username' => 'rootuser',
        'password' => 'rootuser'
      ]
    ],
  ],
  'email'    => [
    'host' => 'localhost',
    'port' => 25,
  ],
];
```

## Get data from your config file

To safe resources we access the config class via singleton pattern ```Config::getInstance()```. By passing the config file path we inform the class which file we want to read. Now, in order to fetch an actual value we pass an existing config array index as array to ```getConfigKeys(['url'])```. As a result we would receive all values which are within the array index of ```url```:

```php
[
  'service'  => '[URL_SERVICE]',
  'frontend' => '[URL_FRONTEND]',
];
```

Multiple array elements will be chained together. According to that the following example will only return the string value for ```['url']['service']```:

```php
use Simplon\Config\Config;

$configPath = __DIR__ . '/../../config/common.config.php';

$urlService = Config::getInstance()
->setConfigPath($configPath)
->getConfigByKeys(['url', 'service']);

echo $urlService; // prints "[URL_SERVICE]"
```