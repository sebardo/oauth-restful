<?php
namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UsersController extends FOSRestController
{
    /**
     * Lists all User entities.
     *
     * @return rest view
     *
     * @Route("/users")
     * @Method("GET")
     */
    public function getUsersAction()
    {
        $data = array(
            array('id' => 1, 'email' => 'email1@email.com', 'name' => 'user1'),
            array('id' => 2, 'email' => 'email2@email.com', 'name' => 'user2'),
        );
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:Users:getUsers.html.twig")
            ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    }

    public function redirectAction()
    {
        $view = $this->redirectView($this->generateUrl('some_route'), 301);
        // or
        $view = $this->routeRedirectView('some_route', array(), 301);

        return $this->handleView($view);
    }
}