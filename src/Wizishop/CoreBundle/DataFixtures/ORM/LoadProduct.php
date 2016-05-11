<?php
/**
 * Created by PhpStorm.
 * User: Stef et JM
 * Date: 10/05/2016
 * Time: 13:58
 */

namespace Wizishop\CoreBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Wizishop\CoreBundle\Entity\Product;

class LoadProduct implements FixtureInterface
{
    // Nombre de produits à créer
    const NB_MAX_PRODUCTS = 12;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::NB_MAX_PRODUCTS; $i++)
        {
            $product = new Product();

            $product->setTitle("produit_".$i);
            $product->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sed sodales nibh, in venenatis sapien. Fusce elementum sapien in interdum porta. Cras porta ullamcorper elementum. Fusce nec massa nec enim dapibus egestas. Vivamus ullamcorper placerat lectus tempus faucibus. Maecenas id magna eget eros pulvinar dapibus. Duis arcu arcu, gravida ac sem at, congue ornare tortor. Vestibulum sit amet diam congue, gravida nulla sed, sagittis nunc. Donec interdum magna ante. Praesent in ante maximus massa lobortis volutpat. Nam quis suscipit tortor, eu aliquet nisi. Fusce ut rutrum sem. Mauris a commodo eros, et vehicula elit. Suspendisse pretium odio ligula, et tristique tellus ultrices sed. ");
            $product->setCategory("category_".rand(1,5));
            $product->setQuantity(rand(1, 10));
            $product->setThumb("p0".rand(1, 3).".png");
            $product->setPrice(rand(199, 299));

            $manager->persist($product);
        }

        $manager->flush();
    }
}