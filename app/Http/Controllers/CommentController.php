<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'comment_at' => now(),
            'parent_id' => $request->parent_id, // <-- tambahkan ini
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk mengedit komentar ini.');
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $comment->update([
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil diperbarui.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Kamu tidak memiliki izin untuk menghapus komentar ini.');
        }

        // Jika komentar utama, hapus juga balasannya
        if ($comment->replies()->count()) {
            $comment->replies()->delete();
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }



}
