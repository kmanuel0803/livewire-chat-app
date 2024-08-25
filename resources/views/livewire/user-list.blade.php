<?php
  use App\Helpers\InitialsHelper;
?>
<div class="max-w-6xl my-10 {{ $isChatboxVisible ? 'mx-50' : 'mx-auto' }}">
    <p class="text-center text-4xl font-bold py-3">Users</p>

    <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-5 p-2 ">

        @foreach ($users as $user)
        <div class="w-full bg-white border border-gray-200 rounded-lg p-5 shadow">
            <div class="flex flex-col items-center pb-2">
                <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-orange-200 rounded-full dark:bg-gray-600">
                    <span class="font-medium text-gray-600 dark:text-gray-300">{{ InitialsHelper::generateInitials($user->name) }}</span>
                </div>
                <h5 class="mb-1 text-xl font-medium text-gray-900">
                    {{$user->name}}
                </h5>
                <span class="text-sm text-gray-500">{{$user->email}}</span>
                <div class="flex mt-4 space-x-3 md:mt-6">
                    <button class="p-3 bg-blue-500 text-white rounded" wire:click="message({{ $user->id }})">
                        Chat now
                    </button>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <livewire:chat-box :isChatboxVisible="$isChatboxVisible" :recipientId="$currentRecipientId"/>
</div>
