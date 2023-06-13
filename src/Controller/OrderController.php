<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\RecapDetails;
use App\Form\OrderType;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/order/create', name: 'order_prepare')]
    public function index(CartService $cartService): Response
    {

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'recapCart' => $cartService->getTotal()
        ]);
    }
    #[Route('/order/verify', name: 'order_verify', methods: ['POST'])]
    public function prepareOrder(CartService $cartService, Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datetime = new \DateTime('now');
            $transporter = $form->get('transporter')->getData();
            $delivery = $form->get('adresses')->getData();

            $deliveryForOrder = $delivery->getFirstname() . ' ' . $delivery->getLastname();
            $deliveryForOrder .= '<br>'. $delivery->getPhone();
            if ($delivery->getCompany()) {
                $deliveryForOrder .= ' - '. $delivery->getCompany();
            }
            $deliveryForOrder .= '<br>'. $delivery->getAdress();
            $deliveryForOrder .= '<br>'. $delivery->getPostalcode() . ' - ' . $delivery->getCity();
            $deliveryForOrder .= '<br>'. $delivery->getCountry();

            $order = new Order();
            
            $reference = $datetime->format('dmY') . '-' . uniqid();
            $order->setUser($this->getUser());
            $order->setReference($reference);
            $order->setCreateAt($datetime);
            $order->setDelivery($deliveryForOrder);
            $order->setTransporterName($transporter->getTitle());
            $order->setTransporterPrice($transporter->getPrice());
            $order->setIsPaid(0);
            $order->setMethod('stripe'); 

            $this->em->persist($order);

            foreach($cartService->getTotal() as $product)
            {
                $recapDetails = new RecapDetails();
                $recapDetails->setOrderProdut($order);
                $recapDetails->setQuantity($product['quantity']);
                $recapDetails->setProduct($product['product']->getTitle());
                $recapDetails->setPrice($product['product']->getPrice());
                $recapDetails->setTotalRecap($product['product']->getPrice() * $product['quantity']);

                $this->em->persist($recapDetails);
            }
            $this->em->flush();

            return $this->render('order/recap.html.twig', [
                'method' => $order->getMethod(),
                'recapCart' => $cartService->getTotal(),
                'transporter' => $transporter,
                'delivery' => $deliveryForOrder,
                'reference' => $order->getReference(),
            ]);
        }
        return $this->redirectToRoute('cart_index');
    }
}
