<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $generator)
    {
        $this->em = $em;
        $this->generator = $generator;
    }

    #[Route('/order/create-session-stripe/{reference}', name: 'payment_stripe')]
    public function stripeCheckout($reference): RedirectResponse
    {
        $productStripe = [];

        $order = $this->em->getRepository(Order::class)->findOneByReference(['reference' => $reference]);

        if (!$order) {
            return $this->redirectToRoute('cart_index');
        }

        foreach ($order->getRecapDetails()->getValues() as $product) {
            $productData = $this->em->getRepository(Product::class)->findOneBy(['title' => $product->getProduct()]);
            $productStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $productData->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct()
                    ],
                ],
                'quantity' => $product->getQuantity()
            ];

        }

        $productStripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getTransporterPrice(),
                'product_data' => [
                    'name' => $order->getTransporterName()
                ],
            ],
            'quantity' => 1,
        ];

            Stripe::setApiKey('sk_test_51NIMUgLEbsJng2nBr71iUFPSN3fPbq6mfiSD3ggOjmcmJ7f69cpqWIhMcQKr0XrTJRWgZM61OTzeXxHV9DkVxrSL00m5eZ3BKi');

            $checkout_session = Session::create([
                'customer_email' => $this->getUser()->getEmail(),
                'payment_method_types' => ['card'],
                'line_items' => [
                    $productStripe
                ],
                'mode' => 'payment',
                'success_url' => $this->generator->generate('payment_success', ['reference' => $order->GetReference()], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generator->generate('payment_error', ['reference' => $order->GetReference()], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

            $order->setStripeSessionId($checkout_session->id);

            $this->em->flush();

            return new RedirectResponse($checkout_session->url);

    }

    #[Route('/order/success/{reference}', name: 'payment_success')]
    public function StripeSuccess($reference, CartService $service): Response
    {
        return $this->render('order/success.html.twig');
    }

    #[Route('/order/error/{reference}', name: 'payment_error')]
    public function StripeError($reference, CartService $service): Response
    {
        return $this->render('order/error.html.twig');
    }
}
