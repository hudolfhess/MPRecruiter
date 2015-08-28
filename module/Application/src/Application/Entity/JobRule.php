<?php
namespace Application\Entity;

use Application\Core\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class JobRule extends Entity
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
     * @var \Application\Entity\JobRuleConfig
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\JobRuleConfig", mappedBy="rule")
     */
    protected $config;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $email_subject;

    /**
     * @ORM\Column(type="text")
     */
    protected $email_content;

}