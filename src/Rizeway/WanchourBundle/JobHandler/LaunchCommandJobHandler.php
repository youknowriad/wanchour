<?php

namespace Rizeway\WanchourBundle\JobHandler;

use Rizeway\JobBundle\JobHandler\ContainerAwareJobHandler;
use Rizeway\WanchourBundle\Entity\Distribution;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use GitElephant\Repository as GitRepo;

class LaunchCommandJobHandler extends ContainerAwareJobHandler
{
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'repository',
            'command_name',
        ));
        
        $resolver->setDefaults(array(
           'distribution' => null
        ));
    }

    public function run()
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $distribution = is_null($this->getOption('distribution')) ? null : $em->getRepository('RizewayWanchourBundle:Distribution')
            ->find($this->getOption('distribution'));
        if (!is_null($distribution)) {
            $config_file = $this->getConfigFileFromDistribution($distribution);
        }
        $repository = $em->getRepository('RizewayWanchourBundle:Repository')
            ->find($this->getOption('repository'));

        $workspace = $this->getWorkspaceDir();
        $anchour = $this->getContainer()->getParameter('wanchour.anchour');
        $dir = md5(microtime());
        exec('mkdir -p '.$workspace.$dir);

        $this->log('Cloning the repository');
        $repo = new GitRepo($workspace.$dir);
        $repo->cloneFrom($repository->getUrl());

        $this->log('Launching the anchour command');
        exec(sprintf('cd %s && %s %s %s',
          $workspace.$dir,
          $anchour, 
          $this->getOption('command_name'),
          is_null($distribution) ? '' : '--config='.$config_file));

        $this->log('Cleaning Temporary Files'); 
        exec('rm -rf '.$workspace.$dir);
        if (!is_null($distribution)) {
            unlink($config_file);
        }

        $this->log('Command Successful');
    }

    protected function getConfigFileFromDistribution(Distribution $distribution)
    {
        $filename = '/tmp/anchour/'.md5(microtime()).'.yml';
        if (!is_dir('/tmp/anchour')) mkdir('/tmp/anchour');
        $file = fopen($filename, 'w+');
        foreach ($distribution->getParameters() as $parameter) {
            fwrite($file, sprintf('%s: "%s"'.PHP_EOL, $parameter->getKey(), $parameter->getValue()));
        }
        fclose($file);

        return $filename;
    }

    private function getWorkspaceDir()
    {
        return __DIR__.'/../../../../web/workspace/';
    }
}