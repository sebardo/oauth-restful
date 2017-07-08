<?php
namespace ApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ApiBundle\Entity\Role;

class RoleCreateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('rest:role-create')
            ->setDescription('Create a user roles')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->container = $this->getApplication()->getKernel()->getContainer();
        $manager = $this->container->get('doctrine')->getManager();
        
        //Roles
        $userRole = new Role();
        $userRole->setName('user');
        $userRole->setRole(Role::USER);
        $manager->persist($userRole);
        
        $managerRole = new Role();
        $managerRole->setName('manager');
        $managerRole->setRole(Role::MANAGER);
        $manager->persist($managerRole);
        
        $companyRole = new Role();
        $companyRole->setName('company');
        $companyRole->setRole(Role::COMPANY);
        $manager->persist($companyRole);
        
        $adminRole = new Role();
        $adminRole->setName('admin');
        $adminRole->setRole(Role::ADMIN);
        $manager->persist($adminRole);
        
        $superRole = new Role();
        $superRole->setName('root');
        $superRole->setRole(Role::SUPER_ADMIN);
        $manager->persist($superRole);
        
        $manager->flush();
        $output->writeln(sprintf('Role user added'));
    }
}