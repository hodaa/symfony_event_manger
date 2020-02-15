<?php

namespace App\Validations;

use PHPUnit\Framework\Constraint\LessThan;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Validation;

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

    /**
     * @param Request $request
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    public function validateRequest(Request $request): array
    {
        $constraints = new Collection([
            'name' => [new NotBlank()],
            'attendance' => [new Optional(new NotBlank())],
            'location' => [new Optional()],
            'type' => [new EqualTo(1)],
            'date' => [new NotBlank(),new Date()],
            'period' => [new NotBlank(),new LessThanOrEqual(60)],

        ]);
        $validator = Validation::createValidator();
        $violations = $validator->validate($request->request->all(), $constraints);
        $validationMessages = [];
        foreach ($violations as $validation) {
            $validationMessages[] = $validation->getMessage();
        }
        return $validationMessages;
    }
}
