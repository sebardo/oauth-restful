<?php
namespace ApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ApiBundle\Entity\Role;
use ApiBundle\Entity\Actor;

class TestUserCreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('rest:test-user-create')
            ->setDescription('Create test user')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container = $this->getApplication()->getKernel()->getContainer();
        $manager = $this->container->get('doctrine')->getManager();
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder(new Actor());
        
        //User admin
        $adminRole = $manager->getRepository('ApiBundle:Role')->findOneByRole(Role::ADMIN);
        $password = 'admin';
        $admin = new Actor();
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.com');
        $admin->addRole($adminRole);
        $encodePassword = $encoder->encodePassword($password, $admin->getSalt());
        $admin->setPassword($encodePassword);
        $admin->setName('Admin');
        $admin->setSurnames('Lastname');
        $manager->persist($admin);
        
        $userRole = $manager->getRepository('ApiBundle:Role')->findOneByRole(Role::USER);
        $password = 'user';
        $user = new Actor();
        $user->setUsername('user');
        $user->setEmail('user@user.com');
        $user->addRole($userRole);
        $encodePassword = $encoder->encodePassword($password, $user->getSalt());
        $user->setPassword($encodePassword);
        $user->setName('User');
        $user->setSurnames('Lastname');
        $manager->persist($user);
        
        $manager->flush();
        $output->writeln(sprintf('Test user added'));
    }
}