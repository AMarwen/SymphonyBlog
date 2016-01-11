<?php
//1-namespace must specify the file path relative to src path
namespace Lynda\MagazineBundle\Controller;

//2-Import this 3 Classes which exist in (vendor/symphony/symphony/src)
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

//3-a class must always  "Controller" class that has been imported at step 2
class DefaultController extends Controller
{
    //4-define the route at the Comment after @Route
    /**
     * @Route("/userInfo/{name}/{age}")
     * @Template()
     */
    //5-action name must be CamelCase and end with "Action"
    public function indexAction($name,$age)
    {

        //6-the action return result will be sent to the View in(Ressources/views/ControllerName/actionname.html.twig) inside of varaible
        return array('name' => $name , 'age'=>$age);
    }
}
