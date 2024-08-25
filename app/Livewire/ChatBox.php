<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversations;
use App\Models\Messages;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatBox extends Component
{
    public $isChatboxVisible = false;
    public $recipient;
    public $recipient_id;
    public $messages;
    public $currentConversationId;
    public $body;

    public function getListeners()
    {
        return [
            'openChat' => 'openChat',
            "echo:chat-box,.MessageSent" => 'loadMessages',
            'scrollOnload' => 'loadMessages'
        ];
    }

    public function openChat($recipientDetails) {
        $this->isChatboxVisible = true;
        $this->recipient = $recipientDetails;
        $this->recipient_id = $recipientDetails['id'];
        $this->initializeConversation();
        $this->dispatch('scrollOnload');
    }

   public function initializeConversation()
    {
        $initiator = Auth::id();
        $recipient_id = $this->recipient['id'];

        $isConversationExists = Conversations::where(function ($query) use ($initiator, $recipient_id) {
            $query->where('sender_id', $initiator)
                ->where('receiver_id', $recipient_id);
        })->orWhere(function ($query) use ($recipient_id, $initiator) {
            $query->where('sender_id', $recipient_id)
                ->where('receiver_id', $initiator);
        })->first();

        if ($isConversationExists) {
            $this->currentConversationId = $isConversationExists->id;
            $this->messages = Messages::with('sender', 'receiver')->where('conversation_id', $this->currentConversationId)->get();
        } else {
            $conversation = Conversations::create([
                "sender_id" => $initiator,
                "receiver_id" => $recipient_id
            ]);

            $this->currentConversationId = $conversation->id;
            $this->messages = collect();
        }
    }

    public function sendMessage() {
        $message = Messages::create([
            'conversation_id' => $this->currentConversationId,
            'sender_id' => Auth::id(),
            'receiver_id' => $this->recipient_id,
            'body' => $this->body,
        ]);

        $this->body = '';

        if($message) {
            MessageSent::dispatch($message);
        }
    }

    public function loadMessages() {
        $this->messages = Messages::where('conversation_id', $this->currentConversationId)->get();
        $this->dispatch('scrollToBottom');
    }

    public function closeChat() {

        $this->isChatboxVisible = false;
        $this->dispatch('chatboxClosed');
    }

    public function render() {
        return view('livewire.chat-box');
    }

}
