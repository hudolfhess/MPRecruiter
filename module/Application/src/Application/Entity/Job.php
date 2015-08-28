<?php
namespace Application\Entity;

use Application\Core\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Job extends Entity
{

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @var \Application\Entity\JobQuestion
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\JobQuestion", mappedBy="job")
     */
    protected $questions;

    /**
     * @var \Application\Entity\JobRule
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\JobRule", mappedBy="job")
     */
    protected $rules;

    public function getFieldQuestions()
    {
        $fields = array();

        foreach ($this->questions as $question) {
            $fields[$question->id] = $question->label;
        }

        return $fields;
    }

    public function getRules()
    {
        $rules = array();

        foreach ($this->rules as $rule) {
            if ($rule->name != '__default') {
                $r = array();
                foreach ($rule->config as $config) {
                    $r[$config->question->id] = $config->min_value;
                }
                $rules[$rule->id] = array(
                    'rules' => $r
                );
            } else {
                $rules['__default'] = array();
            }
        }

        return $rules;
    }

    public function getDefaultRule()
    {
        foreach ($this->rules as $rule) {
            if ($rule->name == '__default') {
                return $rule->id;
            }
        }
        return null;
    }

}