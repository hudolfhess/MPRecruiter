<?php
namespace Application\Validator;

class RecruiterValidator
{

    private $_data = array();

    private $_rules = array();

    public function setData($data)
    {
        if (is_array($data)) {
            $this->_data = $data;
        }
    }

    public function setRules($rules)
    {
        if (is_array($rules)) {
            $this->_rules = $rules;
        }
    }

    public function run()
    {
        if (! empty($this->_data) && ! empty($this->_rules)) {
            $result = new \stdClass();
            $result->rules = array();
            $result->emails = array();

            foreach ($this->_rules as $name=>$config) {
                if ($name !== "__default") {
                    if ($this->_runRules($name) === true) {
                        $result->rules[] = $name;
                        $result->emails[] = $config['email'];
                    }
                }
            }

            if (array_key_exists('__default', $this->_rules) && count($result->rules) == 0) {
                $result->rules[] = '__default';
                $result->emails[] = $this->_rules['__default']['email'];
            }

            return $result;
        }
        return false;
    }

    private function _runRules($name)
    {
        if (array_key_exists($name, $this->_rules)) {
            $rules = $this->_rules[$name]['rules'];
            $pass = true;
            foreach ($rules as $field=>$min) {
                if (! array_key_exists($field, $this->_data)) {
                    $pass = false;
                    break;
                } else if ($min > $this->_data[$field]) {
                    $pass = false;
                    break;
                }
            }
            return $pass;
        }

        return false;
    }

}