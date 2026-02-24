<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $table = 'seo_metas'; 
    
    protected $fillable = [
        'page_slug',
        'title',
        'description',
        'keywords',
        'header_snippet',
    ];

   

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Find meta by page slug
     *
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function findBySlug($slug)
    {
        return static::where('page_slug', $slug)->first();
    }

    /**
     * Get keywords as array
     *
     * @return array
     */
    public function getKeywordsArray()
    {
        if (is_array($this->keywords)) {
            return $this->keywords;
        }

        return $this->keywords ? explode(',', $this->keywords) : [];
    }

    /**
     * Set keywords attribute
     *
     * @param mixed $value
     */
    public function setKeywordsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['keywords'] = implode(',', $value);
        } else {
            $this->attributes['keywords'] = $value;
        }
    }
}