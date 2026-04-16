# YII3-DOCTRINE

The package provides an easy way to integrate the [Yii 3 framework](https://yii3.yiiframework.com) with the [Doctrine ORM](https://www.doctrine-project.org/).

See also:

- [YII3-CACHE-DOCTRINE](https://github.com/klsoft-web/yii3-cache-doctrine) - The package provides the [PSR-16](https://www.php-fig.org/psr/psr-16/) cache using the [Doctrine ORM](https://www.doctrine-project.org/)
- [YII3-RBAC-DOCTRINE](https://github.com/klsoft-web/yii3-rbac-doctrine) - The package provides [Yii RBAC](https://github.com/yiisoft/rbac) storage using the [Doctrine ORM](https://www.doctrine-project.org/)
- [YII3-DATAREADER-DOCTRINE](https://github.com/klsoft-web/yii3-datareader-doctrine) - The package provides a [Yii 3 data reader](https://github.com/yiisoft/data?tab=readme-ov-file#reading-data) that uses the [Doctrine ORM](https://www.doctrine-project.org/)
- [YII3-DOCTRINE-APP](https://github.com/klsoft-web/yii3-doctrine-app)  - A [Yii 3](https://yii3.yiiframework.com) web application template that supports the [Doctrine ORM](https://www.doctrine-project.org/) 
- [YII3-CMS](https://github.com/klsoft-web/yii3-cms) - A content management system based on the [Yii 3 framework](https://yii3.yiiframework.com) and uses the [Doctrine ORM](https://www.doctrine-project.org/)

## Requirement

 - PHP 8.2 or higher.

## Installation

```bash
composer require klsoft/yii3-doctrine
```

## How to use

### 1. Configure the EntityManagerInterface.

Add the Doctrine parameters to the `config/common/params.php`:

```php
return [
    // ...
    'doctrine' => [
        'paths' =>  [__DIR__ . '/../../src/Data/Entities'],
        'isDevMode' => false,
        'connection' => [
            'driver'   => 'pdo_mysql',
            'user'     => 'mydb',
            'password' => 'secret',
            'dbname'   => 'mydb',
        ]
    ],
];
```

Register the Doctrine dependencies in the `config/common/di/application.php`:

```php
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Doctrine\ORM\Proxy\ProxyFactory;

return [
    // ...
    CacheItemPoolInterface::class => ArrayAdapter::class, //One of the following adapters should be used instead: Psr16Adapter, RedisAdapter, MemcachedAdapter, DoctrineDbalAdapter, and so forth.
    Configuration::class => static function (ContainerInterface $container) use ($params) {
        $config = ORMSetup::createAttributeMetadataConfiguration( // on PHP >= 8.4, use ORMSetup::createAttributeMetadataConfig()
            paths: $params['doctrine']['paths'],
            isDevMode: $params['doctrine']['isDevMode'],
            cache: $container->get(CacheItemPoolInterface::class));
        $config->setAutoGenerateProxyClasses(ProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS_OR_CHANGED);
        return $config;
    },
    EntityManagerInterface::class => static function (ContainerInterface $container) use ($params) {
        $configuration = $container->get(Configuration::class);
        return new EntityManager(
            DriverManager::getConnection(
                $params['doctrine']['connection'],
                $configuration
            ),
            $configuration);
    },
    EntityManagerProvider::class => SingleManagerProvider::class,
];
```

### 2. Run the Doctrine console command.

Example:

```bash
APP_ENV=dev ./yii doctrine:orm:schema-tool:create
```

The following commands are currently available:

- doctrine:orm:schema-tool:create
- doctrine:orm:schema-tool:drop
- doctrine:orm:schema-tool:update
- doctrine:orm:clear-cache:metadata
- doctrine:orm:validate-schema
- doctrine:orm:mapping-describe
- doctrine:orm:run-dql
- doctrine:orm:info
- doctrine:orm:generate-proxies
- doctrine:orm:clear-cache:query
- doctrine:orm:clear-cache:result
- doctrine:dbal:run-sql

### 3. Inject the EntityManagerInterface.

Example:

```php
use Doctrine\ORM\EntityManagerInterface;

final class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }
}
```
