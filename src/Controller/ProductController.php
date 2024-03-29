<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em){}


    #[Route('/boutique', name: 'shop_index')]
    public function index(): Response
    {

        $products = $this->em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig',[
            'products' => $products
        ]);
    }

    #[Route('/{category}/{id}', name: 'product_index')]
    public function product(int $id): Response
    {

        $product = $this->em->getRepository(Product::class)->find($id);


        return $this->render('product/product.html.twig',[
            'product' => $product
        ]);
    }
}
