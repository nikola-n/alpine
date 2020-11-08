<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
</head>
<body>
{{--    min-h-screen: take 100% height of the window : min-height:100vh;--}}
<div x-data="game()"
     class="px-10 flex items-center justify-center min-h-screen">
    <h1 class="fixed top-0 right-0 p-10 font-bold text-3xl">
        <span x-text="points"></span>
        <span class="text-xs">pts</span>
    </h1>
    {{--        when you use flex the grid will take as small space as possible, thats--}}
    {{--        why you use flex-1 to fill available space--}}
    <div class="flex-1 grid grid-cols-4 gap-10">
        <template x-for="card in cards">
            <div>
                <button
                    x-show="! card.cleared"
                    :style="'background: ' + (card.flipped ? card.color : '#999')"
                    class="h-32 w-full"
                    @click="flipCard(card)"
                >
                </button>
            </div>
        </template>
    </div>
</div>
{{--flash messages--}}
<div x-data="{ show: false, message: 'Default Message'}"
     x-show.transition.opacity="show"
     x-text="message"
     {{--     custom event with javascript--}}
     @flash.window="message = $event.detail.message;
      show = true;
      setTimeout(()=> show = false, 1000)
"
     class="fixed bottom-0 right-0 bg-green-500 text-white p-2 mb-4 mr-2 rounded"
>
    <span class="pr-4"></span>
    <button @click="show = false">&times;</button>
</div>
<script>
    function pause(miliseconds = 1000) {
        //you cant just write setTimeout because that doesnt return a promise.
        return new Promise(resolve => setTimeout(resolve, miliseconds));
    }

    function flash(message) {
        window.dispatchEvent(new CustomEvent('flash', {
            detail: {message}
        }));
    }

    function game() {
        return {
            cards: [
                {color: 'green', flipped: false, cleared: false},
                {color: 'red', flipped: false, cleared: false},
                {color: 'blue', flipped: false, cleared: false},
                {color: 'yellow', flipped: false, cleared: false},
                {color: 'green', flipped: false, cleared: false},
                {color: 'red', flipped: false, cleared: false},
                {color: 'blue', flipped: false, cleared: false},
                {color: 'yellow', flipped: false, cleared: false}
            ].sort(() => Math.random() - .5),

            // computed property
            get flippedCards() {
                return this.cards.filter(card => card.flipped);
            },
            get clearedCards() {
                return this.cards.filter(card => card.cleared);
            },

            get remainingCards() {
                return this.cards.filter(card => !card.cleared);
            },

            get points() {
                return this.clearedCards.length;
            },

            async flipCard(card) {
                if (this.flippedCards.length === 2) {
                    return;
                }
                card.flipped = !card.flipped;
                if (this.flippedCards.length === 2) {
                    //check for a match
                    if (this.hasMatch()) {
                        flash('You found a match!');
                        //you have a match
                        await pause();
                        this.flippedCards.forEach(card => card.cleared = true);
                        // is the game over?
                        //if there are no remaining cards

                        if (!this.remainingCards.length) {
                            alert('You won!');
                        }
                    }

                    await pause();
                    this.flippedCards.forEach(card => card.flipped = false);


                }
            },
            hasMatch() {
                return this.flippedCards[0]['color'] === this.flippedCards[1]['color']
            }
        };
    }
</script>

</body>

</html>
