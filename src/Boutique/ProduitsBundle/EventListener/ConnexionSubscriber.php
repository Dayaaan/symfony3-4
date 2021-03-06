<?php

namespace Boutique\ProduitsBundle\EventListener;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class ConnexionSubscriber implements EventSubscriberInterface
{
    private $router;
    private $container;

    public function __construct(RouterInterface $router, $container) {

        $this->router = $router;
        $this->container = $container;
        
    }
    public function onKernelRequest(GetResponseEvent $event) {

        $request = $event->getRequest();

        $actualPath = $request->attributes->get('_route');

        dump($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'));

        if ( $actualPath == 'checkout'){
            if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
                $event->setResponse(new RedirectResponse( $this->router->generate('fos_user_security_login', array('_locale'=> "fr")) ));
            }

        }


    }
    /**
    * Returns an array of event names this subscriber wants to listen to.
    *
    * The array keys are event names and the value can be:
    *
    *  * The method name to call (priority defaults to 0)
    *  * An array composed of the method name to call and the priority
    *  * An array of arrays composed of the method names to call and respective
    *    priorities, or 0 if unset
    *
    * For instance:
    *
    *  * array('eventName' => 'methodName')
    *  * array('eventName' => array('methodName', $priority))
    *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
    *
    * @return array The event names to listen to
    */

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.request' => array(array('onKernelRequest', 18))
        );
        
    }
}