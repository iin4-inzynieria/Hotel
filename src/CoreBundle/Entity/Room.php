<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Room
 * @package CoreBundle\Entity
 *
 * @ORM\Table(name="room")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\RoomRepository")
 */
class Room {

    /**
     * Normal room.
     */
    const ROOM_TYPE_DEFAULT = 0;

    /**
     * Premium apartment.
     */
    const ROOM_TYPE_APARTMENT = 1;

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
     * @var Order[]|ArrayCollection()
     *
     * @ORM\OneToMany(targetEntity="Order", mappedBy="room")
     */
    private $orders;

    /**
     * @var Calendar[]|ArrayCollection()
     *
     * @ORM\OneToMany(targetEntity="Calendar", mappedBy="room", cascade={"persist", "remove"})
     */
    private $calendar;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="imageLink", type="string", length=255)
     */
    private $imageLink;

    /**
     * @var integer
     *
     * @ORM\Column(name="roomType", type="integer")
     */
    private $roomType;

    /**
     * Room constructor.
     */
    public function __construct() {
        $this->orders = new ArrayCollection();
        $this->calendar = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param Order $order
     *
     * @return $this
     */
    public function addOrder(Order $order) {
        $this->orders[] = $order;
        return $this;
    }

    /**
     * @param Order $order
     *
     * @return $this
     */
    public function removeOrder(Order $order) {
        $this->orders->removeElement($order);
        return $this;
    }

    /**
     * @return Order[]|ArrayCollection
     */
    public function getOrders() {
        return $this->orders;
    }

    /**
     * @return Calendar[]
     */
    public function getCalendar() {
        return $this->calendar;
    }

    /**
     * @param Calendar $calendar
     *
     * @return Order
     */
    public function addCalendar(Calendar $calendar) {
        $this->calendar[] = $calendar;
        return $this;
    }

    /**
     * @param Calendar $calendar
     *
     * @return $this
     */
    public function removeCalendar(Calendar $calendar) {
        $this->calendar->removeElement($calendar);
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Room
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Set roomType
     *
     * @param integer $roomType
     *
     * @return Room
     */
    public function setRoomType($roomType) {
        $this->roomType = $roomType;

        return $this;
    }

    /**
     * Get roomType
     *
     * @return integer
     */
    public function getRoomType() {
        return $this->roomType;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Room
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set imageLink
     *
     * @param string $imageLink
     *
     * @return Room
     */
    public function setImageLink($imageLink) {
        $this->imageLink = $imageLink;

        return $this;
    }

    /**
     * Get imageLink
     *
     * @return string
     */
    public function getImageLink() {
        return $this->imageLink;
    }
}
