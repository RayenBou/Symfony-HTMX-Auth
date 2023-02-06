# Symfony htmx auth
Un Projet simple sous Symfony utilisant HTMX afin d'initier des requêtes AJAX simplifiées dans une page HTML.



# Introduction

Ce projet permet de tester la facilité d'integration de HTMX afin de gerer les requetes HTTP dans un projet Symfony . HTMX est une librairie JS permettant de faire des requetes AJAX directement dans le code HTML de manière simple.

Sur ce projet nous utilisons HTMX afin de gerer les requetes d'authentification sur une Single Page Application.

Mettez de coté React et adoptez HTMX sur symfony ! :D

## Informations additionnelles

Il existe une multitude de solutions pour la gestion du cache comme Mercure ou encore UX-turbo. Mais nous avons trouvé qu'elle n'etaient ni simples ni intuitifs. L'utilisation de HTMX pour ce projet est tourné autour de la rapidité d'utilisation du code.


Symfony possedant son propre systeme de securité, nous avons fait en sorte d'utiliser au maximum toute la base du framework afin d'ecrire le moins de code.





## Installation

Pour installer ce projet vous aurez besoin d'une base de donnée MySQL. Un log de connexion est visible sur PHPMYADMIN.

Modifiez les informations du .Env en fonction de vos paramètres si necessaire.


```bash
php bin/console doctrine:database:create
```
```bash
php bin/console doctrine:migration:migrate
```

## Explication

La page principale est composé d'une authetification bloquant l'accès au contenue . Le contenue de la page est devoilé après authentification. 
La barre de navigation indique l'état d'authentification en temps réel.



### Appel des formulaires


Quand l'ont clique sur "connexion" ou "s'inscrire" une requete est effectué afin d'appeller le formulaire correspondant. 

Dans la page principale nous pouvons voir :


```bash
templates\home\index.html.twig

  <a hx-get="{{ path('app_register') }}" hx-swap="outerHTML" class="btn btn-secondary" hx-trigger="click">s'inscrire</a>
```

HX-GET : Permet d'effectuer une requête GET sur la route app_register.

HX-SWAP : Permet de preciser quel element du DOM va etre remplacé par le contenue de la requête.

HX-TRIGGER : Permet de definir quel evenement declenche la requête.


### Inscription


La requête effectué avec HTMX se situe dans le FORM de l'inscription:


```bash
src\Form\RegistrationFormType.php

 ->add('submit', SubmitType::class, [
                'label' => "s'inscrire",
                'attr' => [
                    'hx-post' => $options['action'],
                    'hx-target' => '#responsive-div'
                ]
            ]);
```

Cette fois ci nous avons un HX-POST appellant une option du formulaire que nous pouvons retrouver dans le controlleur:

```bash
src\Controller\RegistrationController.php

 $form = $this->createForm(RegistrationFormType::class, $user, [
            'action' => $this->generateUrl('app_register')
        ]);
```

### Connexion


Pour finir nous avons la requête de connexion qui se situe directement dans le formulaire de connexion.


```bash
templates\security\login.html.twig

<button hx-post="{{ path('app_login') }}" hx-swap="outerHTML" hx-target="#responsive-div" class="btn btn-primary" type="submit">
			se connecter
		</button>
```

Similaire au requête d'appel des formulaire et à l'inscription,  HTMX agit directement à la place du bouton SUBMIT habituel.


