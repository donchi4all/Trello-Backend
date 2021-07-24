<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App\Models
 */
class Category extends Model
{
    use HasFactory;

    //It was named category instead of List due because
    //PHP is restricting us from using List
    //List is a keyword in php

    /**
     * @var string
     */
    protected  $table ='lists';

    /**
     * @var string[]
     */
    protected $fillable = ['name' , 'board_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class,'list_id','id');
    }
}
