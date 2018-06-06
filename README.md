# AGREEMENTBUNDLE

AgreementBundle is a symfony bundle to manage agreement bundle like general conditions.


## Installation

Add dependencies in your `composer.json` file:
```json
"require": {
    ...
    "idci/agreement-bundle": "~1.0"
},
```

Install these new dependencies in your application using composer:
```sh
$ composer update
```

Register needed bundles in your application kernel:
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new IDCI\Bundle\AgreementBundle\IDCIAgreementBundle(),
    );
}
```

Import the bundle configuration:
```yml
# app/config/config.yml

imports:
    - { resource: @IDCIAgreementBundle/Resources/config/config.yml }
```

## Tests (using docker)

Install bundle dependencies:
```sh
$ make composer-update
```

To execute unit tests:
```sh
$ make phpunit
```
