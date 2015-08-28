<?php
namespace Application\Entity;

use Application\Core\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class RegisterJobRule extends Entity
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
     * @var \Application\Entity\JobRule
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\JobRule", inversedBy="rules")
     * @ORM\JoinColumn(name="job_rule_id", referencedColumnName="id")
     */
    protected $rules;

}