<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'content',
        'publish_date',
        'status',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
    ];

    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnails')
            ->singleFile()
            ->useFallbackUrl('/images/placeholder.jpg');
    }

    public function getThumbnailAttribute()
    {
        return $this->getFirstMediaUrl('thumbnails');
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 0);
    }

    public function scopeUpdated($query)
    {
        return $query->where('status', 1);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 2);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = $post->generateUniqueSlug($post->title);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title')) {
                $post->slug = $post->generateUniqueSlug($post->title);
            }
        });
    }

    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
    
        while (static::where('slug', $slug)->withTrashed()->exists()) {
            $slug = $originalSlug . '-' . Str::lower(Str::random(3));
        }
    
        return $slug;
    }
    
    // public function getRouteKeyName(): string
    // {
    //     return 'slug';
    // }
}
