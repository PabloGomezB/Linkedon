<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

class ExceptionListener
{

    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        
        $exception = $event->getThrowable();

        if (!$exception instanceof AccessDeniedHttpException) {
            return;
        }

        $route = 'error403';

        if ($route === $event->getRequest()->get('_route')) {
            return;
        }
        $url = $this->router->generate($route); // Ruta definida en LinkedonController
        $response = new RedirectResponse($url);
        $event->setResponse($response);
    }
}