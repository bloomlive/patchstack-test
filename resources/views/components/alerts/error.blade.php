<div class="bg-red-200 border-red-600 text-red-600 border-l-4 p-4" role="alert">
    <p class="font-bold">
        Be Warned
    </p>
    <p>
        {{ session()->get('error') ?? $slot }}
    </p>
</div>
