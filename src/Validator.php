<?php namespace App;

use Symfony\Component\Validator\Validation;

class Validator 
{
    public $validator;
    public $rules = [];

    function __construct()
    {
        $this->validator = Validation::createValidator();

        $this->rules = [
            'required' => [
                'class' => \Symfony\Component\Validator\Constraints\NotBlank::class,
                'message' => Core::$lang['form_field_required']
            ]
        ];
    }

    public function validation(array $data, array $validation = [])
    {
        $errors = [];
        foreach ($validation as $k => $rules) {
            if (!isset($data[$k])) continue;

            $validateRules = [];
            foreach ($rules as $name => $opts) {
                $opts = empty($opts) || is_bool($opts) ? [] : $opts;
                $rule = empty($this->rules[$name]) ? [] : $this->rules[$name];
                $rule = array_merge($rule, $opts);
                if (empty($rule['class']) || !class_exists($rule['class'])) {
                    continue;
                }

                $ruleClass = $rule['class'];
                unset($rule['class']);

                $validateRules[] = new $ruleClass($rule);
            }

            $violations = $this->validator->validate($data[$k], $validateRules);
            if ($violations->count() > 0) {
                foreach ($violations as $violation) {
                    $errors[$k] = $violation->getMessage();   
                }
            }
        }

        return $errors;
    }
}