<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    
    protected $table = 'slider';
    
    protected $fillable = ['name', 'urlTitle', 'url', 'description'];


    public function getPhotoUrl()
    {
        if (!empty($this->photo)) {
            return url('/storage/sliders/' . $this->photo);
        }
        
        return url('/themes/front/img/featured-pic-1.jpeg');
    }
    
    public function deletePhoto()
    {
        if (!$this->photo) {
            return $this;
        }
        
        $photoFilePath = public_path('/storage/sliders/' . $this->photo);
        
        if (!is_file($photoFilePath)) {
            //informacija postoji u bazi ali ga nema na disku
            return $this;
        }
        
        unlink($photoFilePath);
        return $this;
    }
}
