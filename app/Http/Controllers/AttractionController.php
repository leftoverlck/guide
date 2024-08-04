<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Attraction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AttractionController extends Controller
{


    public function index(Request $request)
    {
        $query = Attraction::query();

        if ($request->has('query') && $request->input('query') != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('query') . '%')
                    ->orWhere('details', 'like', '%' . $request->input('query') . '%');
            });
        }

        if ($request->has('region') && $request->input('region') != '') {
            $query->where('region', $request->input('region'));
        }

        if ($request->has('type') && $request->input('type') != '') {
            $query->where('type', $request->input('type'));
        }

        $attractions = $query->paginate(10);

        return view('attractions.index', compact('attractions'));
    }

    public function show($id)
    {
        $attraction = Attraction::with('reviews.user')->findOrFail($id);
        return view('attractions.show', compact('attraction'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
        $attractions = Attraction::where('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();

        return view('attractions.index', compact('attractions', 'query'));
    }

    public function filterByType(Request $request)
    {
        $type = $request->input('type');
        $attractions = Attraction::where('type', $type)->get();
        return view('attractions.index', compact('attractions'));
    }

    public function filter(Request $request)
    {
        $region = $request->input('region');
        $attractions = Attraction::where('region', $region)->get();

        return view('attractions.index', compact('attractions'));
    }

    public function addReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:255',
        ]);

        $attraction = Attraction::findOrFail($id);

        $review = new Review();
        $review->attraction_id = $attraction->id;
        $review->user_id = auth()->user()->id;
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        return redirect()->route('attractions.show', $id)->with('success', 'Відгук успішно додано!');
    }

    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Ви не маєте права видаляти цей відгук.');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Відгук видалено успішно.');
    }
}


