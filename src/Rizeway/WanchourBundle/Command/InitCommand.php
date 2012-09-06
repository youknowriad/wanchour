<?php

namespace Rizeway\WanchourBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputDefinition;

class InitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('rizeway:wanchour:init')
             ->setDescription('Initialize wanchour');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $output->writeln('<info>Initializing ...</info>');
        
        // Clearing Cache
        $command = $this->getApplication()->find('cache:clear');
        $command->run(new ArrayInput(array('command'=> 'clearing cache')), $output);
        
        // Droping Actual Schema
        $command = $this->getApplication()->find('doctrine:schema:drop');
        $command->run(new ArrayInput(array('--force' => true, 'command'=> 'droping schema')), $output);

        // Doctrine Creating Schema
        $command = $this->getApplication()->find('doctrine:schema:create');
        $command->run(new ArrayInput(array('command' => 'creating new schema')), $output);
        
        // Clearing Cache
        $command = $this->getApplication()->find('cache:clear');
        $command->run(new ArrayInput(array('command'=> 'clearing cache')), $output);
        
        $output->writeln('<info>Init finished</info>');

        return 0;
    }

}