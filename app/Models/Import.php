<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class Import extends Model implements WithHeadings,WithHeadingRow,ToModel{
    
    public $guarded = [""];
    protected $table = 'yearly_data';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'height',
        'message',
        'created_at',
        'updated_at'
     
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function headings(): array
        {
            return [
            'date',
            'time',
            'height',
            'message',
            ];
        }

   

    public function model(array $row)
    {
        if($row['height'] != "")
        {
            return new Import([
                'date'=> \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d'),
                'time' => date('h:i:s', strtotime(str_replace(" ", "", $row['time']))), 
                'height' => $row['height'],
                'message' => $row['message'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }




}
