<?php

namespace App\Imports;

use App\Models\CisRenovacion;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class CisRenovacionImport implements ToModel,WithHeadingRow,WithValidation,WithBatchInserts
{
    use Importable;
    private $carga_id;

    public function setCargaId($id)
    {
        $this->carga_id=$id;
    }
    public function model(array $row)
    {
        try{
        $fecha_status=$row['fecha_status'];
        $fecha_status_db=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_status);
        }
        catch(\Exception $e)
        {
            $fecha_status_db=null; 
        }

        $fecha_activacion_contrato=$row['fecha_activacion_contrato'];
        $fecha_activacion_contrato_db=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_activacion_contrato);

        

        return new CisRenovacion([
                            'no_contrato_impreso'=>$row['no_contrato_impreso'],
                            'id_orden_renovacion'=>"".$row['id_orden_renovacion']."",
                            'cuenta_cliente'=>$row['cuenta_cliente'],
                            'status_renovacion'=>$row['status_renovacion'],
                            'fecha_status'=>$fecha_status_db,
                            'id_ejecutivo'=>$row['id_ejecutivo'],
                            'nombre_ejecutivo'=>$row['nombre_ejecutivo'],
                            'co_id'=>$row['co_id'],
                            'fecha_activacion_contrato'=>$fecha_activacion_contrato_db,
                            'new_sim'=>$row['new_sim'],
                            'modelo_nuevo'=>$row['modelo_nuevo'],
                            'plan_actual'=>$row['plan_actual'],
                            'renta_actual'=>$row['renta_actual'],
                            'plazo_actual'=>$row['plazo_actual'],
                            'dn_actual'=>"".$row['dn_actual']."",
                            'propiedad'=>$row['propiedad'],
                            'carga_id'=>$this->carga_id,
                            'user_id'=>Auth::user()->id
        ]);
    }
    public function rules(): array
    {
        return [
            '*.no_contrato_impreso' => ['required'],
        ];
    }
    public function batchSize(): int
    {
        return 100;
    }
}
