<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

use Fachowo\CoreBundle\Entity\Interfaces\EntityInterface;

/**
 * Class Calendar
 * @package CoreBundle\Entity
 *
 * @ORM\Table(name="calendar")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\CalendarRepository")
 */
class Calendar {

    use ORMBehaviors\Timestampable\Timestampable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="available", type="boolean", nullable=false)
     */
    private $available = false;

    /**
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="calendar")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=false)
     **/
    private $room;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="calendar")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=true)
     **/
    private $order;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", length=255)
     */
    private $price;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Calendar
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAvailable() {
        return $this->available;
    }

    /**
     * @param boolean $available
     * @return Calendar
     */
    public function setAvailable($available) {
        $this->available = $available;
        return $this;
    }

    /**
     * @return Room
     */
    public function getRoom() {
        return $this->room;
    }

    /**
     * @param Room $room
     * @return Calendar
     */
    public function setRoom($room) {
        $this->room = $room;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return Calendar
     */
    public function setOrder(Order $order) {
        $this->order = $order;
        return $this;
    }

    /**
     * Raw=true zwraca w grosze (@patrz setPrice komentarz), raw=false zwraca już przeparsowane.
     *
     * @param bool|false $raw
     * @return int|string
     */
    public function getPrice($raw = false) {
        if ($raw) {
            return $this->price;
        }

        return number_format($this->price / 100, 2, '.', '');
    }

    /**
     * Cene tworzymy np: dla 100,- robimy 10000, dla 59,99 robimy 5999 - w groszach
     *
     * @param int $price
     * @return Calendar
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }
}
