package com.amasoft.amaschool_backend.exceptionHandler;

import com.amasoft.amaschool_backend.dto.response.ErrorResponseDto;
import com.amasoft.amaschool_backend.exception.EntityAlreadyExisteException;
import com.amasoft.amaschool_backend.exception.EntityNotFoundException;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ExceptionHandler;

@ControllerAdvice
public class GlobalExceptionHandler {
    @ExceptionHandler(EntityNotFoundException.class)
    public ResponseEntity<ErrorResponseDto> handleEntityNotFoundException(EntityNotFoundException ex) {
        ErrorResponseDto errorResponse = new ErrorResponseDto(HttpStatus.NOT_FOUND.value(), ex.getMessage());
        return ResponseEntity.status(HttpStatus.NOT_FOUND).body(errorResponse);
    }

    @ExceptionHandler(EntityAlreadyExisteException.class)
    public ResponseEntity<ErrorResponseDto> handleEntityAlreadyExisteException(EntityAlreadyExisteException ex) {
        ErrorResponseDto errorResponse = new ErrorResponseDto(HttpStatus.CONFLICT.value(), ex.getMessage());
        return ResponseEntity.status(HttpStatus.CONFLICT).body(errorResponse);
    }
}
