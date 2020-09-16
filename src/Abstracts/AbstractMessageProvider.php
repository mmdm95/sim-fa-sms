<?php

namespace Sim\SMS\Abstracts;

use Sim\SMS\Interfaces\IMessageProvider;

abstract class AbstractMessageProvider implements IMessageProvider
{
    /**
     * @param array $numbers
     * @return array
     */
    protected function validateMobile(array $numbers): array
    {
        $numbers = $this->toEnglishNumbers($numbers);

        $count = count($numbers);
        for ($i = 0; $i < $count; $i++) {
            $numbers[$i] = str_replace([' ', '-'], '', $numbers[$i]);
            if(!(bool)preg_match("/^(098|\+98|0)?9\d{9}$/", $numbers[$i])) {
                unset($numbers[$i]);
            }
        }

        $numbers = $this->removeDuplicateNumbers($numbers);

        return $numbers;
    }

    /**
     * @param $numbers
     * @return array|mixed
     */
    protected function toEnglishNumbers($numbers)
    {
        if (is_array($numbers)) {
            $newArr = [];
            foreach ($numbers as $k => $v) {
                $newArr[$k] = $this->toEnglishNumbers($v);
            }
            return $newArr;
        }

        if (is_string($numbers)) {
            $numbers = str_replace(AbstractSMS::PERSIAN_NUMBERS, AbstractSMS::ENGLISH_NUMBERS, $numbers);
            $numbers = str_replace(AbstractSMS::ARABIC_NUMBERS, AbstractSMS::ENGLISH_NUMBERS, $numbers);
        }

        return $numbers;
    }

    /**
     * @param array $numbers
     * @return array
     */
    protected function removeDuplicateNumbers(array $numbers): array
    {
        return array_values(array_unique($numbers));
    }
}