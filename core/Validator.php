<?php
/**
 * Created by PhpStorm.
 * User: elvis
 * Date: 25.03.2018
 * Time: 13:16
 */

namespace core;


class Validator
{
    public $clean = [];
    public $errors = [];
    public $success = false;
    private $rules;

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function execute(array $fields)
    {
        //todo домашка - написать все методы проверки
        if (!$this->rules) {
//            Ошибка
        }

        foreach ($this->rules as $name => $rules) {
            if (!isset($fields['name']) && isset($rules['required'])) {
                $this->errors[$name][] = sprintf('Field %s is require!', $name);
            }
            //Если поля name не существует, если поля required не существует или оно не обязательно (false)
            if (!isset($fields['name']) && (!isset($rules['required']) || !$rules['required'])) {
                continue;
            }
            // Проверка по типу, тут нужно проверить на тип, если строка то проверить на длинну.
            if (isset($rules['type']) && !$this->isTypeMatching($fields['name'], $rules['type'])) {
                $this->errors[$name][] = sprintf('Type of filend not require!', $name);
            }
            //Проверяем поле not_blank - если присутствует и значение тру, то сравниваем со значением переданного поля
            if (isset($rules['not_blank']) && $rules['not_blank'] && $fields['name'] == '')
                $this->errors[$name][] = sprintf('Field %s is EMPTY!', $name);

            //Проверка на длинну
            if(isset($rules['length']) && !$this->isLenghtMatch($fields[name],$rules['length']))

            if (empty($this->errors[$name]) && isset($fields[$name])) {
                $this->clean[$name] = $fields[$name];
            }
        }
    }

    public function isTypeMatching($field, $type)
    {
        switch ($type) {
            case 'string':
                return is_string($field);
                break;
            case 'int':
            case 'integer':
                return gettype($field) === 'integer' || ctype_digit($field);
                break;
            default:
                break;
        }
    }

    public function isLenghtMatch($field, $length)
    {
        if(is_array($length)){
            $max = isset($length[1]) ? $length[1] : false;
            $min = isset($length[0]) ? $length[0] : false;
        }
        else
        {
            $max = $length;
            $min = false;
        }

        if (is_array($length) && (!$max || !$min)){
            return false;
        }

        if (!is_array($length) && !$max){
            return false;
        }

        $isMaxPassed = $max ? $this->maxPass($length,$max): false;
        $isMinPassed = $min ? $this->minPass($length,$min): false;

        return is_array($length) ? $isMaxPassed && $isMinPassed : $isMaxPassed;
    }

    public function minPass($field, $min)
    {
        return strlen($field) > $min;
    }
    public function maxPass($field, $max)
    {
        return strlen($field) > $max == false;
    }
}