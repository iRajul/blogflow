<?php

namespace irajul\Blogflow\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use irajul\Blogflow\Enums\Status;
use irajul\Blogflow\Enums\Type;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'meta_description',
        'meta_title',
        'featured_image',
        'post_type',
        'content',
        'user_id',
        'published_at',
        'sticky_until',
        'password',
        'ordering',
        'status',
        'views',
        'estimated_reading_time',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'sticky_until' => 'datetime',
        'featured_image' => 'array',
        'content' => 'array',
        'status' => Status::class,
        'post_type' => Type::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('blogflow.user.model'), config('blogflow.user.foreign_key'));
    }

    public function thumbnail(): Collection | string | null
    {
        return $this->getFirstMediaUrl(config('blogflow.featured_image.collection_name'), 'thumbnail');
    }

    public function featuredImage(): Collection | string | null
    {
        return $this->getFirstMediaUrl(config('blogflow.featured_image.collection_name'));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(config('blogflow.featured_image.collection_name'))
            ->useFallbackUrl(config('blogflow.featured_image.fallback_url'));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumbnail')
            ->nonQueued()
            ->performOnCollections(config('blogflow.featured_image.collection_name'))
            ->fit(Fit::Max, config('blogflow.featured_image.thumbnail.width'), config('blogflow.featured_image.thumbnail.height'))
            ->format('webp');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(config('blogflow.user.model'), config('blogflow.user.foreign_key'));
    }

    public function getTable()
    {
        return config('blogflow.tables.prefix') . 'posts';
    }
}
