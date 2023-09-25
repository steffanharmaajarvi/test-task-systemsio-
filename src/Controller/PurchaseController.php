<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{

    #[Route(path: '/calculate-price', methods: ['POST'])]
    public function calculatePrice(): JsonResponse
    {




        return new JsonResponse();
    }

}