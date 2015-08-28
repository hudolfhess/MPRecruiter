<?php
namespace Application\Entity;

use Application\Core\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class RegisterQuestion extends Entity
{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var \Application\Entity\Register
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\Register", inversedBy="register")
     * @ORM\JoinColumn(name="register_id", referencedColumnName="id")
     */
    protected $register;

    /**
     * @var \Application\Entity\JobQuestion
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\JobQuestion", inversedBy="questions")
     * @ORM\JoinColumn(name="job_question_id", referencedColumnName="id")
     */
    protected $questions;

    /**
     * @ORM\Column(type="integer")
     */
    protected $value;

}