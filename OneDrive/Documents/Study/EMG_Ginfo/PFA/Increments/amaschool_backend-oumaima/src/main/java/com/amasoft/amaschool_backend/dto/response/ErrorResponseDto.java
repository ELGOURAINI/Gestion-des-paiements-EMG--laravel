package com.amasoft.amaschool_backend.dto.response;

import lombok.Data;

@Data
public class ErrorResponseDto {
    private int statusCode;
    private String message;

    public ErrorResponseDto(int statusCode, String message) {
        this.statusCode = statusCode;
        this.message = message;
    }
}
