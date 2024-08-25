<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserList extends Component
{
    public $users;
    public $isChatboxVisible = false;
    public $currentRecipientId;

    protected $listeners = ['chatboxClosed' => 'handleChatboxClosed'];

    public function mount() {
        $loggedInUserId = Auth::id();
        $this->users =  User::where('id', '!=', $loggedInUserId)->get();
    }

    public function render() {
        return view('livewire.user-list');
    }

    public function message($recipientId) {
        $recipientDetails = User::find($recipientId);
        $this->isChatboxVisible = true;
        $this->dispatch('openChat', $recipientDetails);
    }

    public function handleChatboxClosed() {
        $this->isChatboxVisible = false;
    }
}
