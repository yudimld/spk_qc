<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Pac extends Eloquent
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('pac');
    }
    protected $connection = 'mongodb';
    protected $fillable = [
        'product_name',
        'appearance',
        'ai2o3_min', 'ai2o3_max',
        'basicity_min', 'basicity_max',
        'ph_1_solution_min', 'ph_1_solution_max',
        'specific_gravity_min', 'specific_gravity_max',
        'turbidity_min', 'turbidity_max',
        'fe_min', 'fe_max',
        'moisture_min', 'moisture_max',
        'cl_min', 'cl_max',
        'so4_min', 'so4_max',
        'shelf_life',
        'kadar_min', 'kadar_max',
        'ph_pure_min', 'ph_pure_max',
        'kelarutan_hcl'
    ];
}
