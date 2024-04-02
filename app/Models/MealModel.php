<?php

namespace App\Models;

use CodeIgniter\Model;

class MealModel extends Model
{
    protected $table      = 'meal';
    protected $primaryKey = 'id_meal';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_proteinFood', 'id_starchyFood', 'id_vegetableFood', 'mealType', 'proteinPortion', 'starchyPortion', 'vegetablePortion'];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = false;

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = false;
}
