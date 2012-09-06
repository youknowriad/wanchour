<?php

namespace Rizeway\WanchourBundle\Utils;

use Rizeway\WanchourBundle\Entity\Repository;
use Doctrine\ORM\EntityManager;
use GitElephant\Repository as GitRepo;
use Symfony\Component\Yaml\Yaml;

class CommandsUpdater
{
    public function update(Repository $repository)
    {
        $workspace = $this->getWorkspaceDir();
        $dir = md5(microtime());
        exec('mkdir -p '.$workspace.$dir);
        $repo = new GitRepo($workspace.$dir);
        $repo->cloneFrom($repository->getUrl());
        $anchour_file = $workspace.$dir.DIRECTORY_SEPARATOR.'.anchour';
        if (!file_exists($anchour_file)) {
            exec('rm -rf '.$workspace.$dir);
            throw new \Exception('The .anchour config file was not found');
        }

        $array = Yaml::parse($anchour_file);
        exec('rm -rf '.$workspace.$dir);
        if (!isset($array['anchour']) || !isset($array['anchour']['commands'])) {
            throw new \Exception('No commands were found in the .anchour config file');
        }

        $repository->setCommands(array_keys($array['anchour']['commands']));
    }

    protected function getWorkspaceDir()
    {
        return __DIR__.'/../../../../web/workspace/';
    }
}
