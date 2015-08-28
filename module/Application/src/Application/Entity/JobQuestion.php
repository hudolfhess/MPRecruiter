<?php
namespace Application\Entity;

use Application\Core\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class JobQuestion extends Entity
{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \Application\Entity\Job
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Job", inversedBy="job")
     * @ORM\JoinColumn(name="job_id", referencedColumnName="id")
     */
    protected $job;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $label;

}