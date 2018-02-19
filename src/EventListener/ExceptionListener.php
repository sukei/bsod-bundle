<?php

/*
 * This file is part of the BSOD Bundle.
 *
 * (c) Quentin Schuler <qschuler@neosyne.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sukei\Bundle\BsodBundle\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Templating\EngineInterface;

/**
 * @author Quentin Schuler <qschuler@neosyne.com>
 */
class ExceptionListener
{
    /**
     * @var EngineInterface
     */
    private $engine;

    /**
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $event->setResponse(new Response($this->engine->render('@SukeiBsodBundle/Resources/views/bsod.html.twig', [
            'exception' => $event->getException(),
        ])));
    }
}
