<?php 
    namespace App\Models;

    use CodeIgniter\Model;

    class ReportModel extends Model
    {
        protected $table = 'reports';
        protected $primaryKey = 'id';
        protected $allowedFields = [
            'nomor', 'jenis', 'waktu', 'latitude', 'longitude', 'kronologi', 'pengungsi', 'image_path', 'username'
        ];

        public function getAllReports()
        {
            $builder = $this->builder();
            return $builder->get()->getResultArray();
        }

    }

    
?>