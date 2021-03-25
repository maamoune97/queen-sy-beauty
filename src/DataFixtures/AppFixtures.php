<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\SubCategory;
use App\Entity\UnregisteredCustomer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = [];
        $prices = [];
        
        $faker = Factory::create('fr_FR');

        $user = new User();
        $passwordHash = $this->encoder->encodePassword($user, 'password');

        $user->setFName('Maamoune')
             ->setLName('Hassane')
             ->setPhoneNumber('3216849')
             ->setPassword($passwordHash)
             ->setEmail('maamoune@qsb.com')
             ;
        
        $manager->persist($user);
        $users[] = $user;

        for ($rc=0; $rc < 15; $rc++)
        { 
            $user = new User();
            $user->setFName($faker->firstName)
             ->setLName($faker->lastName)
             ->setPhoneNumber($faker->phoneNumber)
             ->setPassword($passwordHash)
             ->setEmail($faker->freeEmail)
             ;
        
            $manager->persist($user);
            $users[] = $user;
        }


        for ($p=1000; $p <= 15000; $p+=50)
        { 
            $prices[] = $p;
        }

        for ($o=0; $o < 30; $o++)
        { 
            $order = new Order();

            $order->setPrice($faker->randomElement($prices))
                  ->setStatus($faker->randomElement([0,1,2]))
                  ->setCreatedAt($faker->dateTimeBetween('-8 days'))
                  ;
            
            if ($faker->boolean)
            {
                $order->setCustomer($faker->randomElement($users));
            }
            else
            {
                $unregesiterd = new UnregisteredCustomer();
                $unregesiterd->setFName($faker->firstName)
                            ->setLName($faker->lastName)
                            ->setPhoneNumber($faker->phoneNumber)
                            ->setEmail($faker->freeEmail)
                            ;
        
                $manager->persist($unregesiterd);
                $order->setCustomer($unregesiterd);
            }

            $manager->persist($order);
        }

        for ($c = 0; $c < mt_rand(4, 7); $c++) {
            $category = new Category();
            $category->setName($faker->words(mt_rand(1, 4), true));

            $manager->persist($category);

            for ($s = 0; $s < mt_rand(4, 7); $s++) { 
                $subCategory = new SubCategory();
                $subCategory->setName($faker->words(mt_rand(1, 4), true))
                            ->setCategory($category)
                            ;

                $manager->persist($subCategory);
                for ($p = 0; $p < mt_rand(3, 9); $p++)
                {
                    $description = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
                    
                    $product = new Product();
                    $product->setName($faker->words(mt_rand(1, 4), true))
                        ->setPrice($faker->randomElement($prices))
                        ->setCoverImage('https://picsum.photos/640/480')
                        ->addSubCategory($subCategory)
                        ->setVisible($faker->boolean)
                        ->setDescription($description)
                        ;
                    $manager->persist($product);
                    //$faker->imageUrl(640, 480, 'technics')
                    for ($i = 0; $i < mt_rand(3, 7); $i++) {
                        $image = new ProductImage();
                        $image->setUrl('https://picsum.photos/640/480')
                            ->setCaption($faker->words(mt_rand(1, 4), true))
                            ->setProduct($product);
                        $manager->persist($image);
                    }
                }
            }
        }
        
        $manager->flush();
    }
    
}
