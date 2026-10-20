<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReviewRequest;
use App\Models\FileModel;
use App\Models\ReviewModel;
use App\Services\ImageUploader;
use Illuminate\Support\Facades\Session;

/** Customer testimonials. The author photo is a FileModel with ref_point 'author_image'. */
class ReviewController extends Controller
{
    private const IMAGE_SLOT = 'author_image';

    public function __construct(private ImageUploader $uploader) {}

    public function index()
    {
        $reviews = ReviewModel::orderBy('id', 'DESC')->get();
        $images = FileModel::where('ref_point', self::IMAGE_SLOT)->whereIn('ref_id', $reviews->pluck('id'))->get()->keyBy('ref_id');

        return view('admin.review.index')->with('review', $reviews)->with('images', $images);
    }

    public function create()
    {
        return view('admin.review.form')->with('review', null)->with('image', null);
    }

    public function store(ReviewRequest $request)
    {
        $rev = ReviewModel::create($request->reviewData());
        if ($request->hasFile(self::IMAGE_SLOT)) {
            $this->uploader->attach($request->file(self::IMAGE_SLOT), $this->imageDir(), $rev->id, self::IMAGE_SLOT);
        }
        Session::flash('msg', 'Review by '.$rev->author_name.' added.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-review.index');
    }

    public function show(string $id)
    {
        return redirect()->route('admin-review.edit', $id);
    }

    public function edit(string $id)
    {
        $review = ReviewModel::findOrFail($id);

        return view('admin.review.form')->with('review', $review)
            ->with('image', FileModel::where('ref_point', self::IMAGE_SLOT)->where('ref_id', $review->id)->first());
    }

    public function update(ReviewRequest $request, string $id)
    {
        $rev = ReviewModel::findOrFail($id);
        $rev->update($request->reviewData());
        if ($request->hasFile(self::IMAGE_SLOT)) {
            $this->uploader->replace($request->file(self::IMAGE_SLOT), $this->imageDir(), $rev->id, self::IMAGE_SLOT);
        }
        Session::flash('msg', 'Review by '.$rev->author_name.' saved.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-review.index');
    }

    public function destroy(string $id)
    {
        ReviewModel::findOrFail($id)->delete();
        Session::flash('msg', 'Review deleted.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin-review.index');
    }

    private function imageDir(): string
    {
        return 'uploads/review/'.time();
    }
}
