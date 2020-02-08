<?php

namespace App\Entity;

use App\Enums\EventTypes;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank
     *
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $attendance;

    /**
     * @ORM\Column(type="string")
     */
    private $location;

    /**
     * @ORM\Column(type="string")
     */

    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $period;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Choice(
     *     choices = { 0,1 },
     *     message = "Choose a valid type."
     * )
     */
    private $type;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getAttendance(): ?string
    {
        return $this->attendance;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @return string|null
     */
    public function getPeriod(): ?string
    {
        return $this->period;
    }

    /**
     * @return string|null
     */
//    public function getType(): ?string
//    {
//        return $this->type;
//    }


//    /**
//     * @param int $type
//     * @return $this
//     */
//    public function setType(int $type): self
//    {
//        $this->type = $type;
//
//        return $this;
//    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function setAttendance(int $attendance): self
    {
        $this->attendance = $attendance;

        return $this;
    }
    public function setPeriod(int $period): self
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $types =  new EventTypes();
        return [
            'name' => $this->getName(),
            'location' => $this->getLocation(),
            'attendance' => $this->getAttendance(),
            'period' => $this->getPeriod(),
            'type' => $this->getTypeLabel($this->type),
        ];
    }
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getTypeLabel($type): string
    {
        if (!EventTypes::TYPES[$type]) {
            throw new \InvalidArgumentException("Invalid type");
        }
        return EventTypes::TYPES[$type];
    }

}
