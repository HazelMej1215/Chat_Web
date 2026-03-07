<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('users'));
    }

    public function showAi()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        $isAiChat = true;
        return view('chat.index', compact('users', 'isAiChat'));
    }

    public function show($userId)
    {
        $authId = Auth::id();
        $receiver = User::findOrFail($userId);

        $messages = Message::where(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authId);
        })->orderBy('created_at', 'asc')->get();

        Message::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $users = User::where('id', '!=', $authId)->get();

        return view('chat.index', compact('users', 'receiver', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content'     => 'required|string|max:2000',
        ]);

        $message = Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content'     => $request->content,
        ]);

        return response()->json([
            'id'         => $message->id,
            'content'    => $message->content,
            'sender_id'  => $message->sender_id,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }

    public function fetch(Request $request)
    {
        $request->validate([
            'with_user' => 'required|exists:users,id',
            'last_id'   => 'nullable|integer',
        ]);

        $authId   = Auth::id();
        $withUser = $request->with_user;
        $lastId   = $request->last_id ?? 0;

        $messages = Message::where('id', '>', $lastId)
            ->where(function ($q) use ($authId, $withUser) {
                $q->where(function ($q2) use ($authId, $withUser) {
                    $q2->where('sender_id', $authId)->where('receiver_id', $withUser);
                })->orWhere(function ($q2) use ($authId, $withUser) {
                    $q2->where('sender_id', $withUser)->where('receiver_id', $authId);
                });
            })->orderBy('created_at', 'asc')->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'content'    => $m->content,
                'sender_id'  => $m->sender_id,
                'created_at' => $m->created_at->format('H:i'),
            ]);

        return response()->json($messages);
    }

    public function unread()
    {
        $authId = Auth::id();
        $counts = Message::where('receiver_id', $authId)
            ->where('is_read', false)
            ->selectRaw('sender_id, count(*) as total')
            ->groupBy('sender_id')
            ->pluck('total', 'sender_id');

        return response()->json($counts);
    }

    public function aiChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $accountId = 'b12a6c64f45d3991ecd96ab0040496bd';
        $token     = 'cL8MTadHrSnVtDhIlubMWbnOIiSxUgYh6ejEQPSv';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/json',
        ])->post("https://api.cloudflare.com/client/v4/accounts/{$accountId}/ai/run/@cf/meta/llama-3-8b-instruct", [
            'messages' => [
                ['role' => 'system', 'content' => 'Eres un asistente amigable dentro de una app de chat llamada ChatApp Gamboa. Responde siempre en español.'],
                ['role' => 'user',   'content' => $request->message],
            ],
        ]);

        if ($response->successful()) {
            $reply = $response->json('result.response');
            return response()->json(['reply' => $reply]);
        }

        return response()->json([
            'reply' => 'Error ' . $response->status() . ': ' . $response->body()
        ], 500);
    }
}