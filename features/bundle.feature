Feature: demo symfony application

  Scenario: Check that all methods are available
    # Ensure params doc is present
    When I send a "GET" request on "/my-custom-doc-endpoint" demoApp kernel endpoint
    Then I should have a "200" response from demoApp with following content:
    """
    {
      "methods": [
        {
          "identifier": "BundledMethodA",
          "name": "bundledMethodA",
          "params": {
            "type": "object",
            "nullable": false,
            "required": true,
            "siblings": {
              "a": {
                "type": "string",
                "nullable": true,
                "required": true
              },
              "b": {
                "type": "integer",
                "nullable": true,
                "required": true
              }
            }
          }
        },
        {
          "identifier": "BundledMethodB",
          "name": "bundledMethodB"
        },
        {
          "identifier": "BundledMethodC",
          "name": "bundledMethodC",
          "params": {
            "type": "object",
            "nullable": false,
            "required": true,
            "siblings": {
              "a": {
                "type": "array",
                "nullable": true,
                "required": true,
                "item_validation": {
                  "type": "integer",
                  "nullable": true,
                  "required": false
                }
              }
            }
          }
        }
      ],
      "errors": [
        {
          "id": "ParseError-32700",
          "title": "Parse error",
          "type": "object",
          "properties": {
            "code": -32700
          }
        },
        {
          "id": "InvalidRequest-32600",
          "title": "Invalid request",
          "type": "object",
          "properties": {
            "code": -32600
          }
        },
        {
          "id": "MethodNotFound-32601",
          "title": "Method not found",
          "type": "object",
          "properties": {
            "code": -32601
          }
        },
        {
          "id": "ParamsValidationsError-32602",
          "title": "Params validations error",
          "type": "object",
          "properties": {
            "code": -32602,
            "data": {
              "type": "object",
              "nullable": true,
              "required": true,
              "siblings": {
                "violations": {
                  "type": "array",
                  "nullable": true,
                  "required": false,
                  "item_validation": {
                    "type": "object",
                    "nullable": true,
                    "required": true,
                    "siblings": {
                      "path": {
                        "type": "string",
                        "nullable": true,
                        "required": true,
                        "example": "[key]"
                      },
                      "message": {
                        "type": "string",
                        "nullable": true,
                        "required": true
                      },
                      "code": {
                        "type": "string",
                        "nullable": true,
                        "required": false
                      }
                    }
                  }
                }
              }
            }
          }
        },
        {
          "id": "InternalError-32603",
          "title": "Internal error",
          "type": "object",
          "properties": {
            "code": -32603,
            "data": {
              "type": "object",
              "nullable": true,
              "required": false,
              "siblings": {
                "_class": {"type": "string", "nullable": true, "required": false, "description": "Exception class"},
                "_code": {"type": "integer", "nullable": true, "required": false, "description": "Exception code"},
                "_message": {"type": "string", "nullable": true, "required": false, "description": "Exception message"},
                "_trace": {"type": "array", "nullable": true, "required": false, "description": "PHP stack trace"}
              },
              "allowMissing": true
            }
          }
        }
      ],
      "http": {
        "host": "localhost"
      }
    }
    """
