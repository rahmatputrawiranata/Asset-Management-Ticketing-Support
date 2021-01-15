<?php

namespace App\Exceptions;

use Exception;

class RestApiNotFoundErrorException extends Exception {
    private $error;

    public function __construct($validationsErrors, $message = 'Validation Error', $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);

        $this->errors = $validationsErrors;
    }

    public function render() {
        return response()->json(
            $this->errors
        , 422);
    }
}
