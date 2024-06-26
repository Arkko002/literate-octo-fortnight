<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
	    if ($this->getUser()) {
        return $this->redirectToRoute('app_index');
    }
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();
    return $this->render('login/index.html.twig', [
        'controller_name' => 'LoginController',
        'error' => $error,
        'last_username' => $lastUsername,
    ]);
    }

    #[Route('/consent', name: 'app_consent', methods: ['GET', 'POST'])]
public function consent(Request $request): Response
{
    $clientId = $request->query->get('client_id');
    if (!$clientId || !ctype_alnum($clientId) || !$this->getUser()) {
        return $this->redirectToRoute('app_index');
    }
    $appClient = $this->em->getRepository(Client::class)->findOneBy(['identifier' => $clientId]);
    if (!$appClient) {
        return $this->redirectToRoute('app_index');
    }
    $appProfile = $this->em->getRepository(OAuth2ClientProfile::class)->findOneBy(['client' => $appClient]);
    $appName = $appProfile->getName();

    // Get the client scopes
    $requestedScopes = explode(' ', $request->query->get('scope'));
    // Get the client scopes in the database
    $clientScopes = $appClient->getScopes();

    // Check all requested scopes are in the client scopes
    if (count(array_diff($requestedScopes, $clientScopes)) > 0) {
        return $this->redirectToRoute('app_index');
    }

    // Check if the user has already consented to the scopes
    /** @var User $user */
    $user = $this->getUser();
    $userConsents = $user->getOAuth2UserConsents()->filter(
        fn (OAuth2UserConsent $consent) => $consent->getClient() === $appClient
    )->first() ?: null;
    $userScopes = $userConsents?->getScopes() ?? [];
    $hasExistingScopes = count($userScopes) > 0;

    // If user has already consented to the scopes, give consent
    if (count(array_diff($requestedScopes, $userScopes)) === 0) {
        $request->getSession()->set('consent_granted', true);
        return $this->redirectToRoute('oauth2_authorize', $request->query->all());
    }

    // Remove the scopes to which the user has already consented
    $requestedScopes = array_diff($requestedScopes, $userScopes);

    // Map the requested scopes to scope names
    $scopeNames = [
        'profile' => 'Your profile',
        'email' => 'Your email address',
        'blog_read' => 'Your blog posts (read)',
        'blog_write' => 'Your blog posts (write)',
    ];

    // Get all the scope names in the requested scopes.
    $requestedScopeNames = array_map(fn($scope) => $scopeNames[$scope], $requestedScopes);
    $existingScopes = array_map(fn($scope) => $scopeNames[$scope], $userScopes);

    if ($request->isMethod('POST')) {
        if ($request->request->get('consent') === 'yes') {
            $request->getSession()->set('consent_granted', true);
            // Add the requested scopes to the user's scopes
            $consents = $userConsents ?? new OAuth2UserConsent();;
            $consents->setScopes(array_merge($requestedScopes, $userScopes));
            $consents->setClient($appClient);
            $consents->setCreated(new \DateTimeImmutable());
            $consents->setExpires(new \DateTimeImmutable('+30 days'));
            $consents->setIpAddress($request->getClientIp());
            $user->addOAuth2UserConsent($consents);
            $this->em->getManager()->persist($consents);
            $this->em->getManager()->flush();
        }
        if ($request->request->get('consent') === 'no') {
            $request->getSession()->set('consent_granted', false);
        }
        return $this->redirectToRoute('oauth2_authorize', $request->query->all());
    }
    return $this->render('login/consent.html.twig', [
        'app_name' => $appName,
        'scopes' => $requestedScopeNames,
        'has_existing_scopes' => $hasExistingScopes,
        'existing_scopes' => $existingScopes,
    ]);
}
}
