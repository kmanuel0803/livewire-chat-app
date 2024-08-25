<?php
  use App\Helpers\InitialsHelper;
?>
<div>
    @if ($isChatboxVisible)
        <div class="border-b flex flex-col fixed bottom-0 right-10 w-[325px] h-[500px] bg-white shadow-2xl p-2">
            <header class="w-full sticky inset-x-0 flex border-b bg-white py-3">
                <div class="flex w-full items-center px-2 gap-4">
                    <h6 class="font-bold truncate">
                        {{ $recipient['name'] }}
                    </h6>
                </div>
                <button wire:click="closeChat" class="absolute top-0 right-0 p-2 text-gray-500 hover:text-gray-800">
                   Close
                </button>
            </header>
            <main  id="messages" class="flex flex-col gap-3 p-3 overflow-y-auto flex-grow overscroll-contain overflow-x-hidden w-full my-auto">
                @foreach($messages as $message)
                    <div class="max-w-[85%] flex w-auto gap-2 mt-2 {{ $message->sender_id ===  Auth::id() ? 'ml-auto flex-row-reverse' : '' }}">
                        <div class="shrink-0">
                            <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden rounded-full dark:bg-gray-600 {{ $message->sender_id === Auth::id() ? 'bg-blue-600' : 'bg-orange-200' }}">
                                <span class="font-medium {{ $message->sender_id === Auth::id() ? 'text-white' : 'text-gray-600' }} text-gray-600 dark:text-gray-300">{{ InitialsHelper::generateInitials($message->sender_id) }}</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap text-[15px] rounded-xl p-2 flex flex-col bg-[#f6f6f8fb] {{ $message->sender_id ===  Auth::id() ? 'rounded-br-none bg-blue-600/80 text-white' : 'text-black rounded-bl-none border border-gray-200/40' }}">
                            <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal">{{ $message->body }} </p>
                        </div>
                    </div>
                @endforeach
            </main>
            <footer class="shrink-0 z-10 bg-white inset-x-0">
                <div class="border-t w-full">
                    <form method="POST" autocapitalize="off" wire:submit.prevent="sendMessage">
                        @csrf
                        <input type="hidden" autocomplete="off" style="display:none">
                        <div class="grid grid-cols-12">
                            <input type="text" wire:model="body" autocomplete="off" placeholder="Write your message here"
                            class="col-span-10 bg-gray-100 border-0 outline-0">
                            <button type="submit" class="col-span-2 bg-blue-500 text-white">Send</button>
                        </div>
                    </form>
                </div>
            </footer>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('scrollToBottom', () => {
                const messagesContainer = document.getElementById('messages');
                if (messagesContainer) {
                    setTimeout(() => {
                        messagesContainer.scrollTo({
                            top: messagesContainer.scrollHeight,
                            behavior: 'smooth'
                        });
                    }, 100);
                }
            });

        });
    </script>
</div>
