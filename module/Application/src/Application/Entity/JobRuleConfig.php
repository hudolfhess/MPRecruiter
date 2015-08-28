<?php
namespace Application\Entity;

use Application\Core\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class JobRuleConfig extends Entity
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
     * @ORM\ManyToOne(targetEntity="Application\Entity\JobRule", inversedBy="rule")
     * @ORM\JoinColumn(name="job_rule_id", referencedColumnName="id")
     */
    protected $rule;

    /**
     * @var \Application\Entity\Job
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\JobQuestion", inversedBy="question")
     * @ORM\JoinColumn(name="job_question_id", referencedColumnName="id")
     */
    protected $question;

    /**
     * @ORM\Column(type="integer")
     */
    protected $min_value;

}