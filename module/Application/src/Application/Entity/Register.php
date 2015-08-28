<?php
namespace Application\Entity;

use Application\Core\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Register extends Entity
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
     * @var \Application\Entity\RegisterJobRule
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\RegisterJobRule", mappedBy="register")
     */
    protected $rules;

    /**
     * @var \Application\Entity\RegisterQuestion
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\RegisterJobRule", mappedBy="register")
     */
    protected $questions;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

}