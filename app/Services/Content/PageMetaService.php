<?php

namespace App\Services\Content;

use App\Models\PageMetaModel;
use App\Services\ActivityLogger;
use App\Services\ImageUploader;
use Illuminate\Http\UploadedFile;

/**
 * Saves the editable content of the built-in CMS pages (admin "Page content"):
 * text fields go to `pages_meta` (ref_id = page id, ref_key = field), images to
 * the `files` table via ImageUploader.
 */
class PageMetaService
{
    /** Image slots each built-in page's editor offers, keyed by page id. */
    public const IMAGE_SLOTS = [
        1 => ['home_banner_background', 'section_one_image', 'section_2_image_1', 'section_2_image_2', 'section_2_image_3', 'section_three_image', 'section_4_image_1', 'section_4_image_2', 'section_4_image_3', 'section_6_image'],
        5 => ['banner_background', 'section_2_image_1', 'section_2_image_2', 'section_2_image_3', 'section_4_image_1', 'section_4_image_2', 'section_4_image_3'],
        7 => ['banner_background'],
        8 => ['banner_background', 'section_1_image'],
        6 => ['banner_background', 'section_1_image', 'section_4_image_1', 'section_4_image_2', 'section_4_image_3'],
        2 => ['home_banner_background', 'section_one_image', 'section_2_image_1', 'section_2_image_2', 'section_2_image_3', 'section_three_image'],
        3 => ['home_banner_background'],
        4 => self::UAE_PARCEL_DELIVERY_SLOTS,
        9 => ['home_banner_background', 'section_2_image_1', 'section_2_image_2', 'section_5_image_1', 'section_5_image_2'],
        12 => ['home_banner_background'],
        13 => self::COUNTRY_PAGE_SLOTS,
        17 => ['section_1_image', 'section_2_image_1', 'section_2_image_2', 'section_3_image_1', 'section_4_image_1', 'section_4_image_2', 'section_5_image_1', 'section_5_image_2', 'section_5_image_3', 'section_5_image_4'],
        18 => self::COUNTRY_PAGE_SLOTS,
        19 => self::COUNTRY_PAGE_SLOTS,
        20 => self::COUNTRY_PAGE_SLOTS,
        21 => self::COUNTRY_PAGE_SLOTS,
        22 => self::COUNTRY_PAGE_SLOTS,
        23 => self::COUNTRY_PAGE_SLOTS,
    ];

    /** Any other page id is edited with the UAE parcel delivery template, so it gets that page's slots. */
    public const DEFAULT_IMAGE_SLOTS = self::UAE_PARCEL_DELIVERY_SLOTS;

    private const UAE_PARCEL_DELIVERY_SLOTS = ['home_banner_background', 'section_2_image_1', 'section_2_image_2', 'section_2_image_3', 'section_4_image_1', 'section_4_image_2', 'section_4_image_3'];

    /** Qatar, Kuwait, Lebanon, Jordan, Oman, Bahrain and Saudi pages share one layout. */
    private const COUNTRY_PAGE_SLOTS = [
        'landing_banner_background', 'section_one_image',
        'section_2_image_1', 'section_2_image_2', 'section_2_image_3', 'section_2_image_4',
        'section_3_image_1', 'section_3_image_2', 'section_3_image_3', 'section_3_image_4', 'section_3_image_5',
        'section_4_image_1', 'section_4_image_2', 'section_4_image_3',
        'section_7_image_1', 'section_7_image_2', 'section_7_image_3', 'section_7_image_4', 'section_7_image_5', 'section_7_image_6', 'section_7_image_7',
    ];

    public function __construct(private ImageUploader $uploader, private ActivityLogger $activity) {}

    /**
     * Matches page ids the way the form posts them (a numeric string), falling
     * back to the default slots for anything else.
     *
     * @return array<int, string>
     */
    public static function imageSlotsFor(mixed $pageId): array
    {
        return is_numeric($pageId) ? (self::IMAGE_SLOTS[(int) $pageId] ?? self::DEFAULT_IMAGE_SLOTS) : self::DEFAULT_IMAGE_SLOTS;
    }

    /**
     * Upsert the non-empty text fields. Empty fields are skipped (not cleared),
     * as the editor has always done.
     *
     * @param  array<string, mixed>  $fields
     */
    public function saveText(mixed $pageId, array $fields): void
    {
        foreach ($fields as $key => $value) {
            if ($value != '') {
                $meta = PageMetaModel::where('ref_key', $key)->where('ref_id', $pageId)->first() ?? new PageMetaModel;
                $meta->ref_key = $key;
                $meta->ref_id = $pageId;
                $meta->value = $value;
                $meta->save();

                $this->activity->record('Page Meta Changed For Page : '.$pageId);
            }
        }
    }

    /**
     * Replace the image of every slot this page has that came with an upload.
     *
     * @param  array<string, UploadedFile|null>  $uploads  keyed by slot name
     */
    public function saveImages(mixed $pageId, array $uploads): void
    {
        foreach (self::imageSlotsFor($pageId) as $slot) {
            // Same test as Request::hasFile(): a failed upload has no temp path.
            $file = $uploads[$slot] ?? null;
            if (! $file instanceof UploadedFile || $file->getPath() === '') {
                continue;
            }
            $this->uploader->replace($file, 'uploads/pagemeta/'.$pageId.'/'.microtime(), $pageId, $slot);
            $this->activity->record('Page Meta Changed (File) For Page : '.$pageId);
        }
    }
}
