<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table = 'tb_item';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama','deskripsi','harga','status'];
}
