<?php

namespace App\Services;

use App\Models\Event;
use App\Models\HomeCarouselItem;
use App\Models\MainEvent;
use App\Models\NewsLink;
use App\Models\Sponsor;
use App\Models\SponsorBanner;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class HomeService
{
    /**
     * Mengambil semua data yang diperlukan untuk halaman utama publik.
     */
    public function fetchHomePageData(): array
    {
        $carouselItems = HomeCarouselItem::where('is_published', true)
            ->orderBy('sort_order')
            ->get();

        $testimonials = Testimonial::where('is_published', true)
            ->orderBy('sort_order')
            ->get();
            
        $sponsors = Sponsor::where('is_published', true)
            ->orderBy('sort_order')
            ->get();
            
        $sponsorBanners = SponsorBanner::where('is_published', true)
            ->orderBy('sort_order')
            ->get();
            
        $featuredEvents = Event::where('is_published', true)
            ->where('is_featured', true)
            ->latest('start_date')
            ->limit(3)
            ->get();
            
        $latestNews = NewsLink::where('is_published', true)
            ->latest('published_at')
            ->limit(4)
            ->get();
            
        $mainEvent = MainEvent::first();


        return [
            'carousel' => $carouselItems,
            'testimonials' => $testimonials,
            'sponsors' => $sponsors,
            'sponsorBanners' => $sponsorBanners,
            'featuredEvents' => $featuredEvents,
            'latestNews' => $latestNews,
            'mainEvent' => $mainEvent,
        ];
    }
    
    /**
     * Generic function to create an item.
     */
    public function createItem(string $modelClass, array $data, string $fileField, string $storagePath): \Illuminate\Database\Eloquent\Model
    {
        if (isset($data[$fileField])) {
            $path = $data[$fileField]->store($storagePath, 'public');
            $data[$fileField] = $path;
        }

        return $modelClass::create($data);
    }

    /**
     * Generic function to update an item.
     */
    public function updateItem(\Illuminate\Database\Eloquent\Model $item, array $data, string $fileField, string $storagePath): \Illuminate\Database\Eloquent\Model
    {
        if (isset($data[$fileField])) {
            if ($item->$fileField) {
                Storage::disk('public')->delete($item->$fileField);
            }
            $path = $data[$fileField]->store($storagePath, 'public');
            $data[$fileField] = $path;
        }
        
        $item->update($data);
        return $item;
    }

    /**
     * Generic function to delete an item.
     */
    public function deleteItem(\Illuminate\Database\Eloquent\Model $item, string $fileField): void
    {
        if ($item->$fileField) {
            Storage::disk('public')->delete($item->$fileField);
        }
        $item->delete();
    }
}