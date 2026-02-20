<?php

declare(strict_types=1);

use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;

return [
    'yiisoft/yii-console' => [
        'commands' => [
            'doctrine:orm:schema-tool:create' => CreateCommand::class,
            'doctrine:orm:schema-tool:drop' => DropCommand::class,
            'doctrine:orm:schema-tool:update' => UpdateCommand::class,
            'doctrine:orm:clear-cache:metadata' => MetadataCommand::class,
            'doctrine:orm:validate-schema' => ValidateSchemaCommand::class,
            'doctrine:orm:mapping-describe' => MappingDescribeCommand::class,
            'doctrine:orm:run-dql' => RunDqlCommand::class,
            'doctrine:orm:info' => InfoCommand::class,
            'doctrine:orm:generate-proxies' => GenerateProxiesCommand::class,
            'doctrine:orm:clear-cache:query' => QueryCommand::class,
            'doctrine:orm:clear-cache:result' => ResultCommand::class,
            'doctrine:dbal:run-sql' => RunSqlCommand::class,
        ]
    ]
];
