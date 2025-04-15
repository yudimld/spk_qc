<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent; 
use App\Models\User;

class Spk extends Eloquent
{
    protected $connection = 'mongodb';  // Gunakan koneksi MongoDB
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('spk_qc');
    }

    protected $fillable = [
        'created_by',
        'department',
        'material_type',
        'product_type',
        'jenis_material',
        'bahan_baku',
        'produksi',
        'nama_material',
        'no_spk',
        'batch',
        'feed',
        'datetime',
        'tgl_produksi',
        'equipment',
        'manufacture_date',
        'keterangan',
        'no_mobil',
        'penyerahan_sample',
        'nomor_lot',
        'batch_number',
        'tanggal_kedatangan',
        'dokumen',
        'jenis_bahan',
        'nama_supplier',
        'tgl_sampling',
        'nama_pengirim_sample',
        'nama_customer',
        'jenis_sampel',
        'jumlah_sample',
        'permintaan_tambahan_analisa',
        'status',
        'no_ticket',
        'lokasi',
        'keterangan_lokasi',
        'by',
        'assign_by',
        'selected_checkboxes',
        'test_date',  // untuk tanggal dan waktu test
        'qc_status',  // untuk status QC
        'parameters_data',  // untuk menyimpan data parameter (ke1, ke2, avg, custom_input)
        'reassign_by',
        'code_material',
        'reason',
    ];
    protected $casts = [
        'parameters_data' => 'array',  // Cast parameters_data menjadi array JSON
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'nup');  // Relasi antara Spk dan User berdasarkan 'nup'
    }
}

