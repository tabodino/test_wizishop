<?php

namespace Wizishop\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    // Page index listant les produits
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('WizishopCoreBundle:Product')->findAll();

        return $this->render('WizishopCoreBundle:Core:index.html.twig', array('products' => $products));
    }

    // Page detail produit
    public function viewProductAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em->getRepository('WizishopCoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'Produit non trouvé'
            );
        }

        return $this->render('WizishopCoreBundle:Core:product.html.twig', array('product' => $product));
    }

    // Methode d'ajout au panier
    public function addCartAction($id, Request $request)
    {
        // Récupère la session
        $session = $request->getSession();
        // Vérifie si la session panier existe déjà
        if (!$session->has('cart')) $session->set('cart', array());
        //
        $cart = $session->get('cart');

        $cart[$id] = 1;
        // Vérfie si l'id du produit existe déjà dans notre panier
        if (array_key_exists($id, $cart)) {
            if ($request->query->get('quantity') != null)
                // Affectation nouvelle quantité
                $cart[$id] = $request->query->get('quantity');
        }else {
            if ($request->query->get('quantity') != null)
                // Ajout nouvelle quantité
                $cart[$id] = $request->query->get('quantity');
            else
                // Quantité par défaut
                $cart[$id] = 1;
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('wizishop_core_cart');
    }

    public function removeFromCartAction($id, Request $request)
    {
        // récupère la session
        $session = $request->getSession();
        $cart = $session->get('cart');
        // Vérifier si l'id produit est bien dans le panier
        if (array_key_exists($id, $cart))
        {
            // Supprime le produit de panier
            unset($cart[$id]);
            // Mise à jour de la session
            $session->set('cart', $cart);
        }

        return $this->redirect($this->generateUrl('wizishop_core_cart'));
    }


     // Page recapitulative du panier
    public function viewCartAction(Request $request)
    {
        $session = $request->getSession();

        if (!$session->has('cart')) $session->set('cart', array());

        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('WizishopCoreBundle:Product')->findArray(array_keys($session->get('cart')));

        return $this->render('WizishopCoreBundle:Core:cart.html.twig', array(
            'products' => $products,
            'cart' => $session->get('cart'),
        ));
    }
}
