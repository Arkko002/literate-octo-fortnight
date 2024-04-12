<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    // public  function __construct(private \Auth)
    // {
    // }
    
    #[Route(path: '/authorize', methods: ['GET'])]
    public function authorize(): Response
    {
        // ...
    }

}
