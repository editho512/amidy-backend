<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamp = false;
    public $fillable = ['reference', 'name', 'stock_alert', 'description', 'attributs', 'unit', 'price', 'tva', 'stock'];
    public $casts = [
        'attributs' => 'array'
    ];

    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function photos(){
        return $this->hasMany(PhotoProduct::class, 'product_id', 'id')->orderBy('photo_products.order', 'desc');
    }

    public function generateReference(){
        $id = generateFourNumberMin($this->id);

        $this->reference = 'PRD' . $id ;
        $this->update();
    }

    public function setAttributsAttribute($value){
        $this->attributes['attributs'] = json_encode($value, true);
    }


    public function photoToDelete($photo){
        $photos_updated_id = array_map(function ($el) {
            return $el['id'];
        }, $photo);

        return $this->photos()->whereNotIn("id", $photos_updated_id)->get();
    }

    public function setPrincipalPhoto($photos){
        $principals = array_filter($photos, function($photo){
            return $photo['order'] == 1;
        });

        if(count($principals) > 0){
            $this->photos()->update(['order' => null]);

            foreach ($principals as $key => $principal) {
                # code...
                $this->photos()->whereId($principal['id'])
                    ->update(['order' => 1]);
            }
        }
    }

    public function scopeSearch($query, $search){
        return $query->when(
            $search && $search != "",
            function ($query) use ($search) {
                return $query->where(function ($where) use ($search) {
                    $where->where('name', 'like', '%' . $search . '%');
                    $where->orWhere('reference', 'like', '%' . $search . '%');
                    $where->orWhere('description', 'like', '%' . $search . '%');
                    $where->orWhere('unit', 'like', '%' . $search . '%');
                });
            }
        );
    }

    public  function scopegetPerCategory($query, $categores){
        return  $query->whereHas('categories', function ($where) use ($categores) {
            $where->whereIn('categories.id', $categores);
        });
    }

    public  function scopegetPerTag($query, $tags)
    {
        return  $query->whereHas('tags', function ($where) use ($tags) {
            $where->whereIn('tags.id', $tags);
        });
    }

}
