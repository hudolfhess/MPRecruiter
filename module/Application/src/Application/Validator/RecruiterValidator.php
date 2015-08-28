<?php
namespace Application\Validator;

class RecruiterValidator
{

    /**
     * Dados a serem validados
     *
     * @var array
     */
    private $_data = array();

    /**
     * Regras a serem validadas
     *
     * @var array
     */
    private $_rules = array();

    /**
     * Valor padrão quando o registro não passar em nenhuma das regras
     *
     * @var int
     */
    private $_defaultRule = 0;

    /**
     * Seta os dados a serem validados
     *
     * @param array $data Dados recebidos do cliente
     * @param bool $t     Flag de verificação para necessidade de tratar os dados recebidos
     */
    public function setData(array $data, $t = false)
    {
        if (is_array($data)) {
            if ($t == false) {
                $this->_data = $data;
            } else {
                $this->_data = $this->_verifyData($data);
            }
        }
    }

    /**
     * Prepara os dados a serem salvos no banco de dados
     *
     * @return array
     */
    public function prepareData()
    {
        $r = array();

        foreach ($this->_data as $id=>$value) {
            $r[] = array(
                'job_question_id' => $id,
                'value' => $value
            );
        }

        return $r;
    }

    /**
     * Prepara as regras a serem salvas no banco de dados
     *
     * @param array $rules Regras
     *
     * @return array
     */
    public function prepareRules(array $rules)
    {
        $r = array();
        foreach ($rules as $id) {
            if ($id == '__default') {
                $id = $this->_defaultRule;
            }
            $r[] = array(
                'job_rule_id' => $id
            );
        }

        return $r;
    }

    /**
     * Faz o tratamento dos dados recebidos
     *
     * @param array $data Dados
     *
     * @return array
     */
    private function _verifyData(array $data)
    {
        $nData = array();
        $pattern = '/answer_([0-9]{1,3})/i';
        foreach ($data as $v=>$i) {
            if (preg_match($pattern, $v, $m)) {
                $nData[$m[1]] = $i;
            }
        }
        return $nData;
    }

    /**
     * Seta o valor padrão
     *
     * @param int $val Valor padrão
     */
    public function setDefaultRule($val)
    {
        $this->_defaultRule = $val;
    }

    /**
     * Define as regras a serem validadas
     *
     * @param array $rules Regras
     */
    public function setRules(array $rules)
    {
        if (is_array($rules)) {
            $this->_rules = $rules;
        }
    }

    /**
     * Executa as validaçóes e retorna quais as regras que passaram
     *
     * @return bool|\stdClass
     */
    public function run()
    {
        if (! empty($this->_data) && ! empty($this->_rules)) {
            $result = new \stdClass();
            $result->rules = array();

            foreach (array_keys($this->_rules) as $name) {
                if ($name !== "__default") {
                    if ($this->_runRules($name) === true) {
                        $result->rules[] = $name;
                    }
                }
            }

            if (array_key_exists('__default', $this->_rules) && count($result->rules) == 0) {
                $result->rules[] = '__default';
            }

            return $result;
        }
        return false;
    }

    /**
     * Executa a validação da regra individualmente
     *
     * @param string $name Nome da regra
     *
     * @return bool
     */
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