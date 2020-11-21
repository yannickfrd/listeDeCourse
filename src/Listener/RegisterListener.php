<?php

namespace App\Listener;

use App\AppService\MailingService;
use App\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;

class RegisterListener {
    private MailingService $mailing;

    public function __construct(MailingService $mailing) {
        $this->mailing = $mailing;
    }

    /** @param LifecycleEventArgs $args */
    public function postPersist(LifecycleEventArgs $args):void {
        $entity = $args->getEntity();
        if ($entity instanceof User) $this->mailing->registerMailer($entity);
    }
}