<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notes\StoreNoteRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('notes.index', [
            'notes' => Note::where('user_id', Auth::user()->id)->get(['id', 'title', 'content']),
            'user' => User::where('id', Auth::user()->id)->firstOrFail(),
            'categories' => Category::where('user_id', Auth::user()->id)->get(['id', 'name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreNoteRequest $request
     * @return Response
     */
    public function store(StoreNoteRequest $request)
    {
        $note = Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::user()->id
        ]);

        $note->categories()->attach($request->categories);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateNoteRequest $request
     * @param Note $note
     * @return Response
     * @throws AuthorizationException
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $this->authorize('update', $note);

        $note->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        $note->categories()->sync($request->categories);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Note $note
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->delete();

        return redirect()->back();
    }
}
