<?php

use League\Bundle\OAuth2ServerBundle\Repository\AuthCodeRepository;
use League\Bundle\OAuth2ServerBundle\Repository\RefreshTokenRepository;
use League\Bundle\OAuth2ServerBundle\Repository\AccessTokenRepository;
use League\Bundle\OAuth2ServerBundle\Repository\ClientRepository;
use League\Bundle\OAuth2ServerBundle\Repository\ScopeRepository;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$container = new ContainerBuilder();
