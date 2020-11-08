<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello Alpine</title>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .active {
            color: blue;
        }

        .line-through {
            text-decoration: line-through;
        }
    </style>
</head>
<body>

<h1>Data Binding</h1>

<div x-data="{ message: 'Hello World!' }">
    <h1 x-text="message"></h1>
    <button @click="message = 'Hello Nikola!'">Click Me</button>

    <input type="text" x-model="message" />
</div>

<br>
<hr>

{{-- calculator--}}
<div x-data="{ first:0, second:0 }">
    <input type="text" x-model.number="first"> + <input type="text" x-model.number="second"> =
    <output x-model="first + second"></output>
</div>

<br>
<hr>
<h1>Toggle Visibility</h1>

<div x-data="{ show: false }">
    {{--    <h1 x-show="show">Hello World</h1>--}}
    <button @click="show = ! show" x-text="show ? 'Hide' : 'Show'"></button>
    <div>
        <a href="/" style="display: block;">Home</a>
        <a href="/" style="display: block;">About</a>
        <a href="/" style="display: block;">Contact</a>
    </div>
</div>

<div x-data="{ currentTab: 'first' }">
    <button @click="currentTab = 'first'"
            :class="{ 'active': currentTab === 'first'} ">First
    </button>
    <button @click="currentTab = 'second'"
            :class="{ 'active': currentTab === 'second'} ">Second
    </button>
    <button @click="currentTab = 'third'"
            :class="{ 'active': currentTab === 'third'} ">Third
    </button>

    <div style="border:1px dotted grey; padding:1rem; margin-top:1rem;">
        <div x-show="currentTab === 'first'">
            <p>First.</p>
        </div>
        <div x-show="currentTab === 'second'">
            <p>Second.</p>
        </div>

        <div x-show="currentTab === 'third'">
            <p>Third.</p>
        </div>
    </div>

    <br>
    <hr>
    <h1>Two way data binding</h1>
    <form x-data="{
     form: {
        name: ''

        },

        user: null,

        submit() {
           fetch('https://reqres.in/api/users', {
                method: 'POST',
                headers: { 'Content-Type':'application/json' },
                body: JSON.stringify(this.form),
           })
           .then(response => response.json())
           .then(user => this.user = user);
        }
     }"
          @submit.prevent="submit">
        <div class="mb-6">
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name">
                Name
            </label>
            <input class="border border-gray-400 p-2 w-full"
                   type="text"
                   name="name"
                   id="name"
                   x-model="form.name"
                   required>
        </div>
        <template x-if="user">
            <div x-text="'The user ' + user.name + ' was created at ' + user.createdAt "></div>
        </template>
    </form>

    <br>
    <hr>
    <h1>How and when to extract component logic</h1>

    <div x-data="taskApp()">
        <form @submit.prevent="submit">
            <input type="text" placeholder="Go to the market..." x-model="newTask">
        </form>

        <ul>
            <template x-for="(task, index) in tasks" :key="index">
                <li>
                    <input type="checkbox" x-model="task.completed">
                    <span x-text="task.body" :class="{ 'line-through' : task.completed }"></span>
                </li>
            </template>
        </ul>
    </div>

    <br>
    <hr>

    <h1>Transitions</h1>
    <div class="grid items-center justify-center h-screen">
        <div x-data="{ show: true }">
            <div class="w-12 h-12">
                <div class="bg-green-500 w-full h-full"
                     x-show="show"
                     x-transition:enter="transition transform duration-1000"
                     x-transition:enter-start="opacity-0 scale-125"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition duration-2000"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"></div>
            </div>
            <button @click="show = ! show">Toggle</button>
        </div>
    </div>
    <br>
    <hr>
    <h1>Transitions 2</h1>
    <div class="grid items-center justify-center h-screen">

        <div x-data="{ show: false }" @click.away="show = false">
            <button @click="show = ! show">Links</button>
            <div class="absolute bg-black text-white py-2"
                 x-show="show"
                 x-transition:enter="transition duration-200 transform ease-out"
                 x-transition:enter-start="scale-75"
                 x-transition:leave="transition duration-100 transform ease-in"
                 x-transition:leave-end="opacity-0 scale-90"
            >
                <a class="block hover:bg-gray-800 text-xs py-px px-4" href="#">Edit</a>
                <a class="block hover:bg-gray-800 text-xs py-px px-4" href="#">Delete</a>
                <a class="block hover:bg-gray-800 text-xs py-px px-4" href="#">Report Spam</a>
            </div>
        </div>
    </div>
    <br>
    <hr>
    {{-- Flash--}}
    <h1>Handling Custom Event</h1>
    <div class="p-12">
        <div x-data>
            <button @click="$dispatch('flash','hello there')">trigger flash message</button>
        </div>

        <div x-data="{ show:false, message: '' }"
             x-show.transition.opacity.scale.75.duration="show"
             @flash.window="
             show = true;
             message = $event.detail;
             setTimeout(()=> show = false, 3000);
             "
             class="fixed bottom-0 right-0 mb-4 mr-4 bg-blue-500 text-white p-4 rounded"
             x-text="message">
            {{--            <button @click="alert('I was clicked!)">Click me</button>--}}
        </div>
    </div>
</div>

<script>
    window.flash = message => window.dispatchEvent(new CustomEvent('flash', {detail: message}));
</script>
</body>
</html>
