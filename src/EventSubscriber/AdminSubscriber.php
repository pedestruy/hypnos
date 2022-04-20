<?php

namespace App\EventSubscriber;

use App\Entity\Contacts;
use App\Entity\Reservations;
use App\Entity\Sites;
use App\Entity\Suites;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return[
            BeforeEntityPersistedEvent::class => ['setCreatedAt'],
            BeforeEntityUpdatedEvent::class => ['setUpdatedAt']
        ];
    }

    public function setCreatedAt(BeforeEntityPersistedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();

        if(!$entityInstance instanceof Suites && !$entityInstance instanceof Sites && !$entityInstance instanceof Contacts && !$entityInstance instanceof Reservations) return;

        $entityInstance->setCreatedAt(new \DateTimeImmutable);
    }

    public function setUpdatedAt(BeforeEntityUpdatedEvent $event)
    {
        $entityInstance = $event->getEntityInstance();

        if(!$entityInstance instanceof Suites && !$entityInstance instanceof Sites && !$entityInstance instanceof Contacts && !$entityInstance instanceof Reservations) return;

        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
    }

}
