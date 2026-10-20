<?php

namespace Tests\Unit;

use App\Models\FileModel;
use App\Services\ImageUploader;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ImageUploaderTest extends TestCase
{
    use DatabaseTransactions;

    /** @var array<int, string> */
    private array $dirs = [];

    /** A scratch folder, removed in tearDown(). */
    private function scratchDir(): string
    {
        $dir = storage_path('app/test_uploads_'.uniqid());
        mkdir($dir, 0777, true);

        return $this->dirs[] = $dir;
    }

    /**
     * Cleanup runs here, not inside the test: on Windows the fake upload keeps
     * its temp file open until the test method returns, and a folder holding
     * an open file can't be removed (that left empty test_uploads_* folders).
     */
    protected function tearDown(): void
    {
        gc_collect_cycles();
        foreach ($this->dirs as $dir) {
            File::deleteDirectory($dir);
        }
        parent::tearDown();
    }

    private function storeImage(UploadedFile $file, string $destination): string
    {
        return (new ImageUploader)->store($file, $destination);
    }

    public function test_valid_image_is_accepted_and_stored_with_random_name(): void
    {
        $dir = $this->scratchDir();

        $file = UploadedFile::fake()->create('photo.jpg', 10, 'image/jpeg');
        $storedName = $this->storeImage($file, $dir);

        $this->assertFileExists($dir.'/'.$storedName);
        $this->assertStringEndsWith('.jpg', $storedName);
        $this->assertNotSame('photo.jpg', $storedName);

    }

    public function test_non_image_file_is_rejected(): void
    {
        $dir = $this->scratchDir();

        $file = UploadedFile::fake()->create('shell.php', 10, 'application/x-php');

        $this->expectException(HttpException::class);

        $this->storeImage($file, $dir);
    }

    public function test_path_traversal_filename_is_neutralized(): void
    {
        $dir = $this->scratchDir();

        $file = UploadedFile::fake()->create('../../evil.jpg', 10, 'image/jpeg');
        $storedName = $this->storeImage($file, $dir);

        $this->assertStringNotContainsString('..', $storedName);
        $this->assertFileExists($dir.'/'.$storedName);
    }

    public function test_delete_uploaded_files_removes_physical_file_and_soft_deletes_record(): void
    {
        $dir = public_path('uploads/test_orphan_'.uniqid());
        mkdir($dir, 0777, true);
        $testFile = $dir.'/old.jpg';
        file_put_contents($testFile, 'fake');

        $record = new FileModel;
        $record->name = 'old.jpg';
        $record->path = 'uploads/'.basename($dir);
        $record->ref_id = 999999;
        $record->ref_point = 'unit_test_field';
        $record->alt_text = '';
        $record->save();

        $collection = FileModel::where('ref_id', 999999)->where('ref_point', 'unit_test_field')->get();
        (new ImageUploader)->delete($collection);

        $this->assertFileDoesNotExist($testFile);
        $this->assertDatabaseMissing('files', ['id' => $record->id, 'deleted_at' => null]);

        File::deleteDirectory($dir);
        FileModel::withTrashed()->find($record->id)->forceDelete();
    }
}
