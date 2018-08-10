<?php

declare(strict_types=1);

namespace App\Core\Factory;

use Psr\Container\ContainerInterface;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

final class DocumentManagerFactory
{
    public function __invoke(ContainerInterface $container): Connection
    {
        $config = $container->get('config')['doctrine']['connection']['default'];

        AnnotationDriver::registerAnnotationClasses();

        $odmConfig = new Configuration();
        $odmConfig->setProxyDir($config['proxies_dir']);
        $odmConfig->setProxyNamespace($config['proxies_namespace']);
        $odmConfig->setHydratorDir($config['hydrators_dir']);
        $odmConfig->setHydratorNamespace($config['hydrators_namespace']);
        $odmConfig->setMetadataDriverImpl(AnnotationDriver::create($config['documents_dir']));

        var_dump(DocumentManager::create(new Connection(), $odmConfig));exit();
    }
}