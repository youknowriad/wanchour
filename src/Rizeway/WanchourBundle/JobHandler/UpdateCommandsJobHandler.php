<?php

namespace Rizeway\WanchourBundle\JobHandler;

use Rizeway\JobBundle\JobHandler\ContainerAwareJobHandler;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GitElephant\Repository as GitRepo;
use Rizeway\WanchourBundle\Utils\CommandsUpdater;

class UpdateCommandsJobHandler extends ContainerAwareJobHandler
{
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'repository'
        ));
    }

    public function run()
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $repository = $em->getRepository('RizewayWanchourBundle:Repository')
            ->find($this->getOption('repository'));

        $this->log('Updating commands');
        $updater = new CommandsUpdater();
        $updater->update($repository);

        $this->log('Commands successfully updated');
    }

    protected function getConfigFileFromDistribution(Distribution $distribution)
    {
        $filename = '/tmp/anchour/'.md5(microtime()).'.yml';
        if (!is_dir('/tmp/anchour')) mkdir('/tmp/anchour');
        $file = fopen($filename, 'w+');
        foreach ($distribution->getParameters() as $parameter) {
            fwrite($file, sprintf('%s: "%s"', $parameter->getKey(), $parameter->getValue()));
        }
        fclose($file);

        return $filename;
    }

    private function getWorkspaceDir()
    {
        return __DIR__.'/../../../../web/workspace/';
    }
}