<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Exercise extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'video_url',
    ];


    protected function embedUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // Return null if there's no video_url to process
                if (empty($attributes['video_url'])) {
                    return null;
                }

                // Parse the URL to get its query components
                parse_str(parse_url($attributes['video_url'], PHP_URL_QUERY), $query);

                // Check if the 'v' parameter exists (the video ID)
                if (isset($query['v'])) {
                    // Construct the embed URL
                    return 'https://www.youtube.com/embed/' . $query['v'];
                }

                // Return the original URL if it's not a standard YouTube link
                return $attributes['video_url'];
            },
        );
    }



     /**
     * NEW: Get the thumbnail URL for the YouTube video.
     * This accessor automatically generates a link to the video's thumbnail image.
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (empty($attributes['video_url'])) {
                    // Return a path to a default placeholder image if no video URL exists
                    return 'https://placehold.co/1280x720/e2e8f0/e2e8f0?text=No+Video';
                }

                // Regular expression to find the YouTube video ID from various URL formats
                $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

                if (preg_match($pattern, $attributes['video_url'], $match)) {
                    $videoId = $match[1];
                    // Fetches the high-quality thumbnail image
                    return "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
                }

                // Fallback if the URL is not a valid YouTube link
                return 'https://placehold.co/1280x720/e2e8f0/e2e8f0?text=Invalid+Link';
            }
        );
    }
    public function coach()
        {
            // Assuming your 'exercises' table has a 'coach_id' column
            return $this->belongsTo(Coach::class);
        }
}
