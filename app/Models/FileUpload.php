<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FileUpload extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'name',
        'path',
        'type',
        'description',
        'parent',
        'ref_id',
        'ref_no'
    ];    
}
