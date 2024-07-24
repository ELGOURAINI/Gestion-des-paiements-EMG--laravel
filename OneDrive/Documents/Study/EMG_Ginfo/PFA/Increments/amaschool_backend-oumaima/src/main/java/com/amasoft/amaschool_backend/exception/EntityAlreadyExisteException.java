package com.amasoft.amaschool_backend.exception;

public class EntityAlreadyExisteException extends RuntimeException {
    public EntityAlreadyExisteException(String message) {
        super(message);
    }
}
