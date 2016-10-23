<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Order
 * @package CoreBundle\Entity
 *
 * @ORM\Table(name="order")
 * @ORM\Entity
 */
class Order
{
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
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="orders", cascade={"persist"})
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=true)
     */
    protected $client;

    /**
     * @var Room
     *
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="orders", cascade={"persist"})
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=false)
     */
    protected $room;

    /**
     * @var Calendar[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Calendar", mappedBy="order", cascade={"persist"})
     */
    protected $calendar;


    /**
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", length=15, nullable=true)
     */
    protected $orderId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrival_date", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    protected $arrival;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_date", type="datetime", nullable=false)
     */
    protected $departure;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=40, nullable=false)
     */
    protected $status = '@TODO';

    public function __construct()
    {
        $this->calendar = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return Order
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return Room
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param Room $room
     * @return Order
     */
    public function setRoom($room)
    {
        $this->room = $room;
        return $this;
    }

    /**
     * @return Calendar[]
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * @param Calendar $calendar
     * @return Order
     */
    public function addCalendar(Calendar $calendar)
    {
        $this->calendar[] = $calendar;
        return $this;
    }

    /**
     * @param Calendar $calendar
     * @return $this
     */
    public function removeCalendar(Calendar $calendar)
    {
        $this->calendar->removeElement($calendar);
        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return Order
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getArrival()
    {
        return $this->arrival;
    }

    /**
     * @param \DateTime $arrival
     * @return Order
     */
    public function setArrival($arrival)
    {
        $this->arrival = $arrival;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeparture()
    {
        return $this->departure;
    }

    /**
     * @param \DateTime $departure
     * @return Order
     */
    public function setDeparture($departure)
    {
        $this->departure = $departure;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}