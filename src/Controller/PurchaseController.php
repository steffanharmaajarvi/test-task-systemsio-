<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Tax;
use App\Enum\PaymentProcessorEnum;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\PaymentService;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{

    public function __construct(
        private PurchaseService $purchaseService,
        private ValidatorInterface $validator,
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private PaymentService $paymentService
    ) {

    }

    #[Route(path: '/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        Request $request
    ): JsonResponse
    {
        $requestData = $request->toArray();

        $violations = $this->validator->validate(
            $requestData,
            new Collection([
                'product' => new Sequentially([
                    new NotBlank(message: 'Product is required'),
                    new Type(type: 'integer', message: 'Product must be integer'),
                ]),
                'couponCode' => new Sequentially([
                    new Type(type: 'string', message: 'Coupon is required'),
                ]),
                'taxNumber' => new Sequentially([
                    new NotBlank(message: 'taxNumber is required'),
                    new Type(type: 'string', message: 'taxNumber must be string'),
                    new Regex(pattern: '/(?xi)^(
                        (EL|GR)?[0-9]{9} |                            # Greece
                        (DE)?[0-9]{9} |                               # Germany
                        (FR)?[0-9A-Z]{2}[0-9]{9} |                    # France
                        (IT)?[0-9]{11}                            # Italy
                    )$/im',
                        message: 'Invalid taxNumber or unsupported country'
                    )
                ]),
            ])
        );

        if ($violations->count() > 0) {
            return new JsonResponse([
                'error' => $violations->get(0)->getMessage()
            ], status: 400);
        }

        $product = $this->productRepository->find($requestData['product']);

        $coupon = null;
        if (isset($requestData['couponCode'])) {
            $coupon = $this->couponRepository->findOneBy([
                'code' => $requestData['couponCode']
            ]);
        }

        $tax = new Tax($requestData['taxNumber']);

        return new JsonResponse([
            'price' => $this->purchaseService->calculatePrice(
                $product,
                $tax,
                $coupon,
            )
        ]);
    }

    #[Route(path: '/purchase', methods: ['POST'])]
    public function purchase(
        Request $request
    ): JsonResponse
    {
        $requestData = $request->toArray();

        $violations = $this->validator->validate(
            $requestData,
            new Collection([
                'product' => new Sequentially([
                    new NotBlank(message: 'Product is required'),
                    new Type(type: 'integer', message: 'Product must be integer'),
                ]),
                'couponCode' => new Sequentially([
                    new Type(type: 'string', message: 'Coupon is required'),
                ]),
                'paymentProcessor' => new Sequentially([
                    new NotBlank(message: 'PaymentProcessor is required'),
                    new Choice(
                        options: [PaymentProcessorEnum::PAYPAL->value, PaymentProcessorEnum::STRIPE->value],
                        message: 'Invalid PaymentProcessor'
                    )
                ]),
                'taxNumber' => new Sequentially([
                    new NotBlank(message: 'taxNumber is required'),
                    new Type(type: 'string', message: 'taxNumber must be string'),
                    new Regex(pattern: '/(?xi)^(
                        (EL|GR)?[0-9]{9} |                            # Greece
                        (DE)?[0-9]{9} |                               # Germany
                        (FR)?[0-9A-Z]{2}[0-9]{9} |                    # France
                        (IT)?[0-9]{11}                            # Italy
                    )$/im',
                        message: 'Invalid taxNumber or unsupported country'
                    )
                ]),
            ])
        );

        if ($violations->count() > 0) {
            return new JsonResponse([
                'error' => $violations->get(0)->getMessage()
            ], status: 400);
        }

        $product = $this->productRepository->find($requestData['product']);

        $coupon = null;
        if (isset($requestData['couponCode'])) {
            $coupon = $this->couponRepository->findOneBy([
                'code' => $requestData['couponCode']
            ]);
        }

        $tax = new Tax($requestData['taxNumber']);
        $paymentProcessor = PaymentProcessorEnum::fromString($requestData['paymentProcessor']);

        $price = $this->purchaseService->calculatePrice(
            $product,
            $tax,
            $coupon,
        );

        return new JsonResponse([
            'paid' => $this->paymentService->pay($price, $paymentProcessor)
        ]);
    }

}