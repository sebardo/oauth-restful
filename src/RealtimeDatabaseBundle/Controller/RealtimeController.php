<?php
namespace RealtimeDatabaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RealtimeController extends Controller
{

    /**
     * @Route("/realtime", name="realtime_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $firebase = $this->get('kreait_firebase.first');
        $db = $firebase->getDatabase();
        $schema = 'schema_003';
        $ref = $db->getReference('schemas/'.$schema)->getValue();
 
        
        if($request->getMethod() == 'POST'){
            //check if exist in schema and save
            if(isset($ref[$request->request->get('seat')])) {
                if($ref[$request->request->get('seat')]['status'] == 'free'){
                    $db->getReference('schemas/'.$schema.'/'.$request->request->get('seat').'/status')->set('reserved');
                }else{
                    $db->getReference('schemas/'.$schema.'/'.$request->request->get('seat').'/status')->set('free');
                }
            }
        }
        
        return array('schemas' => $ref);
    }
}
