<?php

namespace App\Services;

use App\Models\FileModel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Image uploads for the CMS (page sections, country pages, review photos).
 *
 * Files live under public/ and are tracked in the `files` table by
 * (ref_id, ref_point): the record id the image belongs to and the slot it fills.
 */
class ImageUploader
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

    private const ALLOWED_MIMES = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];

    /**
     * Validate the upload is an image and move it into $destinationPath under a
     * random name (never the client-supplied one). Aborts with 422 otherwise.
     *
     * @return string the stored file name
     */
    public function store(UploadedFile $file, string $destinationPath): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (! in_array($extension, self::ALLOWED_EXTENSIONS) || ! in_array($file->getMimeType(), self::ALLOWED_MIMES)) {
            abort(422, 'Only image files are allowed.');
        }

        $safeName = Str::random(40).'.'.$extension;
        $file->move($destinationPath, $safeName);

        return $safeName;
    }

    /**
     * Store the image under public/$relativeDir and record it as filling
     * $refPoint of record $refId.
     */
    public function attach(UploadedFile $file, string $relativeDir, int|string $refId, string $refPoint): FileModel
    {
        $f = new FileModel;
        $f->name = $this->store($file, public_path($relativeDir));
        $f->path = $relativeDir;
        $f->ref_id = $refId;
        $f->ref_point = $refPoint;
        $f->alt_text = '';
        $f->save();

        return $f;
    }

    /** Like attach(), but first removes whatever image currently fills that slot. */
    public function replace(UploadedFile $file, string $relativeDir, int|string $refId, string $refPoint): FileModel
    {
        $this->delete(FileModel::where('ref_point', $refPoint)->where('ref_id', $refId)->get());

        return $this->attach($file, $relativeDir, $refId, $refPoint);
    }

    /**
     * Remove the physical files and soft-delete their records.
     *
     * @param  Collection<int, FileModel>  $files
     */
    public function delete(Collection $files): void
    {
        foreach ($files as $old) {
            $oldPath = public_path($old->path.'/'.$old->name);
            if (is_file($oldPath)) {
                @unlink($oldPath);
            }
        }

        $files->each->delete();
    }
}
