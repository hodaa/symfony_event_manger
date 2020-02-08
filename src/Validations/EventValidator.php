<?php

namespace App\Validations;

use Symfony\Component\HttpFoundation\Request;

class EventValidator
{
    private $violations = [];

    /**
     * @param Request $request
     * @return array
     */
    public function validate(Request $request): array
    {
        if ((int)$request->get('type') !== 0 &&  (int)$request->get('type') !== 1) {
            $this->violations = ['message' => "Type is invalid "];
        }
        if ($request->get('type') == 0) {
            if ($request->get('attendance') > 4) {
                $this->violations = ['message' => "You should not enter more than 4 For meeting "];
            }
        } elseif ($request->get('type') == 1) {
            if ($request->get('attendance') > 2) {
                $this->violations = ['message' => "You should not enter more than 2  For call"];
            }
        }
        return $this->violations;
    }
}
