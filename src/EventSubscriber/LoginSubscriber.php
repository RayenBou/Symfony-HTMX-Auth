<?php

namespace App\EventSubscriber;

use App\Entity\Login;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
        ];
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        // Enregistrez ici les informations de connexion dans la base de données
        // Utilisez $this->entityManager pour enregistrer les informations

        $login = new Login();
        $login->setUser($user);
        $login->setDate(new \DateTime());

        $this->entityManager->persist($login);
        $this->entityManager->flush();
    }
}
