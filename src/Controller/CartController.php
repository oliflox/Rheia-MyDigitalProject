<?php

namespace App\Controller;


use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getTotal()
        ]);
    }

    #[Route('/mon-panier/add/{id<\d+>}', name: 'cart_add')]
    public function addToRoute(CartService $cartService, int $id): Response
    {
        $cartService->addToCart($id);

        $this->addFlash('add', 'Le produit a bien été ajouté au panier');
        return $this->redirectToRoute('shop_index');
    }

    #[Route('/mon-panier/remove/{id<\d+>}', name: 'cart_remove')]
    public function removeToCart(CartService $cartService, int $id): Response
    {
        $cartService->removeToCart($id);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/mon-panier/plus/{id<\d+>}', name: 'cart_plus')]
    public function plusToCart(CartService $cartService, int $id): RedirectResponse
    {
        $cartService->plusToCart($id);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/mon-panier/minus/{id<\d+>}', name: 'cart_minus')]
    public function minusToCart(CartService $cartService, int $id): RedirectResponse
    {
        $cartService->minusToCart($id);

        return $this->redirectToRoute('cart_index');
    }
    
}
