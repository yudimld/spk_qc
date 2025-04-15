<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Specialty extends Eloquent
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('specialty');
    }

    protected $connection = 'mongodb';
    protected $fillable = [
        'product_name',
        'appearance',
        'solution',
        'ph_value_min', 'ph_value_max',
        'sg_min', 'sg_max',
        'sg_01_min', 'sg_01_max',
        'viscosity_min', 'viscosity_max',
        'viscosity_01_min', 'viscosity_01_max',
        'dry_weight',
        'purity_min', 'purity_max',
        'specific_gravity_min', 'specific_gravity_max',
        'specific_gravity_01_min', 'specific_gravity_01_max',
        'moisture_water_min', 'moisture_water_max',
        'residue_on_ignition_min', 'residue_on_ignition_max', 
        'solid_content_min', 'solid_content_max',
        'shelf_life',
        'keterangan'
    ];
}
