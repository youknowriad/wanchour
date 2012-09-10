<?php
namespace Rizeway\JobBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rizeway\JobBundle\Entity\Job;
use Rizeway\JobBundle\Logger\DoctrineLogger;
use Rizeway\JobBundle\Logger\LoggerInterface;

declare(ticks = 1);

class DaemonCommand extends ContainerAwareCommand
{
    protected $running = false;
    protected $job;
    protected $logger;

    protected function configure()
    {
        $this
            ->setName('rizeway:job:daemon')
            ->setDescription('The job daemon launcher');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager();
        $job = $em->getRepository('RizewayJobBundle:Job')->findOneBy(array('status' => Job::STATUS_NEW), array('created_at' => 'ASC'));
        if (is_null($job)) {
            $output->writeln('No jobs in queue');  
        } else {
            $this->logger = $logger = new DoctrineLogger($job, $em);
            $this->job = $job;

            pcntl_signal(SIGTERM, array($this, 'checkExit'));
            pcntl_signal(SIGINT, array($this, 'checkExit'));

            $job->setStatus(Job::STATUS_RUNNING);
            $em->flush();
            $this->running = true;

            try {
                $classname = $job->getClassname();
                if (!class_exists($classname)) {
                    throw new \Exception(sprintf('The job class "%s" was not found', $classname));
                }
                $job_object = new $classname();
                if (!$job_object instanceof \Rizeway\JobBundle\JobHandler\JobHandlerInterface) {
                    throw new \Exception(sprintf('The job object doesn\'t implement the JobHandler Interface'));
                }
                if ($job_object instanceof \Symfony\Component\DependencyInjection\ContainerAwareInterface) {
                    $job_object->setContainer($this->getContainer());
                }
                $job_object->setOptions($job->getOptions());
                $job_object->setLogger($logger);
                $job_object->run();

                $job->setStatus(Job::STATUS_SUCCESS);
                $em->flush();
            } catch (\Exception $e) {
                $output->writeln(sprintf('Error in the job "%s" : %s',
                    $job->getName(),
                    $e->getMessage()));

                $logger->log($e->getMessage(), LoggerInterface::PRIORITY_ERROR);

                $job->setStatus(Job::STATUS_ERROR);
                $em->flush();
            }

            $this->running = false;
        }
    }

    public function checkExit()
    {
        if ($this->running)
        {
            $em = $this->getContainer()->get('doctrine')->getEntityManager();
            if (!is_null($this->logger)) {
                $this->logger->log('The job has been forced to stop', LoggerInterface::PRIORITY_ERROR);
            }
            $this->job->setStatus(Job::STATUS_ERROR);
            $em->flush();
        }

        exit;
    }
}