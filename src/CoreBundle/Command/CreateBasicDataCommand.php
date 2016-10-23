<?php

namespace CoreBundle\Command;

use CoreBundle\Entity\Calendar;
use CoreBundle\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateBasicDataCommand extends ContainerAwareCommand
{
    /** @var OutputInterface */
    private $output;

    /** @var InputInterface */
    private $input;

    protected function configure()
    {
        $this
            ->setName('create:basic:data')
            ->setDescription('O_o');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $em = $this->getContainer()->get('doctrine')->getManager();

        $output->writeln("<info>Ceny podajemy w groszach, czyli: dla 99,99 piszemy 9999, dla 10,- piszemy 1000</info>");

        $rooms = $this->createRooms();

        foreach ($rooms as $room) {
            $this->createCalendarForRoom($room);
            $em->persist($room);
        }

        $em->flush();
    }

    /**
     * @return Room[]
     */
    private function createRooms()
    {
        $roomOne = new Room();
        $roomOne->setTitle('Pokój pierwszy');

        $roomTwo = new Room();
        $roomTwo->setTitle('Pokój drugi');

        $roomThree = new Room();
        $roomThree->setTitle('Pokój trzeci');

        return [$roomOne, $roomTwo, $roomThree];
    }

    private function createCalendarForRoom(Room $entity)
    {
        $priceQuestion = new Question("Podaj cenę dla pokoju \"{$entity->getTitle()}\": ");
        $price = $this->getHelper('question')->ask($this->input, $this->output, $priceQuestion);

        $now = new \DateTime('now');
        $now->setTime(00, 00, 00);

        $year = new \DateTime('now');
        $year->add(new \DateInterval('P1Y'));
        $year->setTime(00, 00, 00);

        $interval = new \DateInterval("P1D");
        $period = new \DatePeriod($now, $interval, $year->add($interval));

        foreach ($period as $day) {
            $entityDay = new Calendar();
            $entityDay->setAvailable(true)
                ->setDate($day)
                ->setRoom($entity)
                ->setPrice($price);

            $entity->addCalendar($entityDay);
        }
    }
}