<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Gresik extends Eloquent
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('code_material_gresik');
    }

    protected $connection = 'mongodb';
    protected $fillable = [
        'material_code',
        'material_name',
        'dimension',

    ];
}
