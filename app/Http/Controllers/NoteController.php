<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->latest('updated_at')->paginate(5);
        return view('notes.index')->with('notes', $notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:120',
            'content' => 'required'
        ]);

        Auth::user()->notes()->create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'content' => $request->content
        ]);

        return to_route('notes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Note $note
     * @return Response
     */
    public function show(Note $note)
    {
        $note = Note::where('user_id', Auth::id())->where('id', $note->id)->firstOrFail();

        if(!$note->user->is(Auth::user())) {
            return abort(403);
        }

        return view('notes.show')->with('note', $note);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Note $note
     * @return Response
     */
    public function edit(Note $note)
    {
        if(!$note->user->is(Auth::user())) {
            return abort(403);
        }

        return view('notes.edit')->with('note', $note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Note $note
     * @return Response
     */
    public function update(Request $request, Note $note)
    {

        if(!$note->user->is(Auth::user())) {
            return abort(403);
        }

        $request->validate([
            'title' => 'required|max:120',
            'content' => 'required'
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return to_route('notes.show', $note)->with('success','Note updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Note $note
     * @return Response
     */
    public function destroy(Note $note)
    {
        if(!$note->user->is(Auth::user())) {
            return abort(403);
        }

        $note->delete();

        return to_route('notes.index')->with('success', 'Note moved to trash');
    }
}
