<?php
namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Entity\Actor;

class SecurityController extends Controller
{
 
    /**
     * @Route("/oauth/v2/auth/login" , name="oauth_login")
     * @Template("ApiBundle:Security:login.html.twig")
     */
    public function loginAction(Request $request)
    {
//        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY') ) {
//                return $this->redirect($this->get('router')->generate('index'));
//        }

        return $this->login($request);
    }

    private function login(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        // Add the following lines
        if ($session->has('_security.target_path')) {
            if (false !== strpos($session->get('_security.target_path'), $this->generateUrl('fos_oauth_server_authorize'))) {
                $session->set('_fos_oauth_server.ensure_logout', true);
            }
        }
        
        return array(
                // last username entered by the user
                'last_username' => $session->get(Security::LAST_USERNAME),
                'error'         => $error,
            );
    }
    
    /**
     * @Route("/api/me", name="me")
     */
    public function userAction(Request $request)
    {
        $userInfo = array();
        $user = $this->getUser();
        if ($user instanceof Actor) {
            $userInfo['username'] = $user->getUsername();
            $userInfo['email'] = $user->getEmail();
            $userInfo['id'] = $user->getId();
        }

        return new JsonResponse($userInfo);
    }
}
