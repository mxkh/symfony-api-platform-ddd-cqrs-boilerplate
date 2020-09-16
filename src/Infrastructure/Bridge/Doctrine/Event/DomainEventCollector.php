<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Bridge\Doctrine\Event;

use Acme\Domain\AggregateRootInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

final class DomainEventCollector implements EventSubscriber
{
    private ArrayCollection $entities;

    public function __construct()
    {
        $this->entities = new ArrayCollection();
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->collect($args->getEntity());
    }

    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->collect($args->getEntity());
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->collect($args->getEntity());
    }

    public function preFlush(PreFlushEventArgs $args): void
    {
        $unitOfWork = $args->getEntityManager()->getUnitOfWork();
        foreach ($unitOfWork->getIdentityMap() as $class => $entities) {
            foreach ($entities as $entity) {
                $this->collect($entity);
            }
        }
    }

    public function postFlush(PostFlushEventArgs $args): void
    {
        return;
    }

    private function collect(object $entity): void
    {
        if ($entity instanceof AggregateRootInterface && !$this->entities->contains($entity)) {
            $this->entities->add($entity);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::preRemove,
            Events::preFlush,
            Events::postFlush,
        ];
    }

    /**
     * @return ArrayCollection|AggregateRootInterface[]
     */
    public function getEntities(): ArrayCollection
    {
        return $this->entities;
    }
}
