<?php

namespace App\Imports;

use App\Models\CisPospago;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class CisPospagoImport implements ToModel,WithHeadingRow,WithValidation,WithBatchInserts
{
    use Importable;
    private $carga_id;

    public function setCargaId($id)
    {
        $this->carga_id=$id;
    }
    public function model(array $row)
    {
        $fecha_contratacion=$row['fecha_contratacion'];
        $fecha_contratacion_db=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_contratacion);

        $fecha_status_orden=$row['fecha_status_orden'];
        $fecha_status_orden_db=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_status_orden);

        return new CisPospago([
                    'no_contrato_impreso'=>$row['no_contrato_impreso'],
                    'id_orden_contratacion'=>$row["id_orden_contratacion"],
                    'fecha_contratacion'=>$fecha_contratacion_db,
                    'cuenta_cliente'=>$row['cuenta_cliente'],
                    'nombre_cliente'=>$row['nombre_cliente'],
                    'tipo_venta'=>$row['tipo_venta'],
                    'status_orden'=>$row['status_orden'],
                    'fecha_status_orden'=>$fecha_status_orden_db,
                    'nombre_pdv_unico'=>$row['nombre_pdv_unico'],
                    'cve_unica_ejecutivo'=>$row['cve_unica_ejecutivo'],
                    'nombre_ejecutivo_unico'=>$row['nombre_ejecutivo_unico'],
                    'id_contrato'=>$row['id_contrato'],
                    'mdn_inicial'=>$row['mdn_inicial'],
                    'propiedad'=>$row['propiedad'],
                    'mdn_actual'=>$row['mdn_actual'],
                    'sim'=>$row['sim'],
                    'imei'=>$row['imei'],
                    'plan_tarifario_homo'=>$row['plan_tarifario_homo'],
                    'plazo_forzoso'=>$row['plazo_forzoso'],
                    'nva_renta'=>$row['nva_renta'],
                    'mdn_definitivo'=>$row['mdn_definitivo'],
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
