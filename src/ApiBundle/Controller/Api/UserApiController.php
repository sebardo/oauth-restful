<?php
namespace ApiBundle\Controller\Api;

use AppBundle\Entity\OAuthAccessToken;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ApiBundle\Entity\AccessToken;
use ApiBundle\Entity\Actor;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use ApiBundle\Form\ActorType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserApiController extends FOSRestController
{
  /**
   * @Rest\Get("/users", name="get_users")
   */
  public function getUsersAction()
  {
      
//    $token = $this->get('fos_oauth_server.access_token_manager')->findTokenByToken($this->get('security.token_storage')->getToken()->getToken());
//
//    if(!$token instanceof AccessToken){
//      throw new AccessDeniedException();
//    }

    $em = $this->getDoctrine()->getManager();
    $data = $em->getRepository('ApiBundle:Actor')->findBy(array());
    $view = $this->view($data, 200);

    return $this->handleView($view);

  }
  
  /**
    * Creates a new Actor entity.
    *
    * @Rest\Post("/users/new", name="new_user")
    * @param Request $request
    * @return Product|array
    */
   public function newAction(Request $request)
   {
        $user = new Actor();
        $form = $this->createForm(ActorType::class, $user);

        $this->processForm($request, $form);

        if (!$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            $view = $this->view(array('status' => 'success', 'error' => $errors), 400);
            return $this->handleView($view);

        }else{
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $view = $this->view(array('status' => 'success'), 200);
            return $this->handleView($view);
        }
        
        $view = $this->view($form, 200);
        return $this->handleView($view);
       
   }
   
   private function processForm(Request $request, FormInterface $form)
    {
        $data = $request->request->all();
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }

   private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}
