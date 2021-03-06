<?php
namespace FF\FastBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FF\FastBundle\Entity\Produits;



/**
 * @ORM\Entity
 * @ORM\Table(name="cart")
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $total_price;
    /**
     * @var string
     *
     * @ORM\Column(name="user", type="string", length=255,)
     */
    private $user;
     /** @ORM\OneToMany(targetEntity="Shipping", mappedBy="cart") */
    protected $cartProducts;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cartProducts = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     *
     * @return Cart
     */
    public function setTotalPrice($totalPrice)
    {
        $this->total_price = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->total_price;
    }


    /**
     * Add cartProduct
     *
     * @param \FF\FastBundle\Entity\Shipping $cartProduct
     *
     * @return Cart
     */
    public function addCartProduct(\FF\FastBundle\Entity\Shipping $cartProduct)
    {
        $this->cartProducts[] = $cartProduct;

        return $this;
    }

    /**
     * Remove cartProduct
     *
     * @param \FF\FastBundle\Entity\Shipping $cartProduct
     */
    public function removeCartProduct(\FF\FastBundle\Entity\Shipping $cartProduct)
    {
        $this->cartProducts->removeElement($cartProduct);
    }

    /**
     * Get cartProducts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCartProducts()
    {
        return $this->cartProducts;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Cart
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }
}
