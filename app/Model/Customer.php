<?php

require_once 'app/Model.php';

class Customer extends \App\Model
{

    protected $table = 'customers';

    protected $columns = [
        'name',
        'email',
        'phone',
    ];

    protected $unique = [
        'email',
        'phone',
    ];

}