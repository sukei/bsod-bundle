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

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @author Quentin Schuler <qschuler@neosyne.com>
 */
class KrakenListener
{
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() === HttpKernelInterface::MASTER_REQUEST) {
            \Kraken::getInstance()->unleash();
        }
    }
}
