<?php

namespace App\Entity;

use App\Entity\Traits\EntityColoredNameTrait;
use App\Entity\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * Describes an Area. An Area is a collection of Locations
 *
 * @author Draeius
 * @Entity
 * @Table(name="areas")
 */
class Area extends RhunEntity {

    use EntityIdTrait;
    use EntityColoredNameTrait;

    /**
     * The city this area belongs to
     * @var string
     * @Column(type="string", length=64)
     */
    protected $city;

    /**
     * A description of this area
     * @var string
     * @Column(type="text", nullable=true)
     */
    protected $description;

    /**
     *
     * @var boolean
     * @Column(type="boolean")
     */
    protected $deadAllowed;

    /**
     *
     * @var bool
     * @Column(type="boolean")
     */
    protected $raceAllowed = false;

    public function getDescription() {
        return $this->description;
    }

    public function getCity() {
        return $this->city;
    }

    public function getDeadAllowed() {
        return $this->deadAllowed;
    }

    function getRaceAllowed() {
        return $this->raceAllowed;
    }

    function setRaceAllowed(bool $raceAllowed) {
        $this->raceAllowed = $raceAllowed;
    }

    public function setDeadAllowed($deadAllowed): bool {
        $this->deadAllowed = $deadAllowed;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

}
