<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Tangerang extends Eloquent
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('code_material_tangerang');
    }

    protected $connection = 'mongodb';
    protected $fillable = [
        'material_code',
        'material_name',
        'dimension',

    ];
}
