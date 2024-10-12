<x-fieldworker-dashboard-layout>
    <x-slot:title>Birthday Cash Gift - Status Form</x-slot:title>
    <section class="flex items-center justify-center w-full h-screen">
        <form action="/fieldworker/birhtday-cash-gift/update-status/{{$person->id}}" method="POST" class="border-gray-300 border-2 p-5 rounded-lg bg-white shadow-lg flex flex-col gap-5" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <h1 class="text-xl font-medium">Birthday Celebrant Status Form</h1>
            <article class="mt-5 flex flex-col gap-3">
                <p><strong>Name:</strong> {{ $person->first_name }} {{ $person->last_name }} </p>
                <p><strong>Birthdate:</strong> {{ Carbon\Carbon::parse($person->date_of_birth)->format('F j, Y') }} </p>
                <p><strong>Address:</strong> {{ $person->present_house }} {{ $person->present_sitio }}, {{ $person->present_city }} </p>
                <p><strong>Assisted:</strong> {{ $person->submittedForm->assisted_by }} </p>
                <div class="flex w-full gap-3 items-center">
                    <p><strong>Status:</strong></p>
                    <select name="status" required class="border-2 border-red-700 p-2 text-sm outline-none rounded-lg w-full">
                        <option disabled selected>-- Select Status --</option>
                        <option value="unreleased" @selected($person->birthdayCashGift->status === 'unreleased')>Unreleased</option>
                        <option value="processing" @selected($person->birthdayCashGift->status === 'processing')>Processing</option>
                        <option value="released" @selected($person->birthdayCashGift->status === 'released')>Released</option>
                    </select>
                </div>
                <input type="hidden" name="person_id" value="{{ $person->id }}">
                <input type="file" name="proof" class="border-2 border-red-700 p-2 text-sm outline-none rounded-lg w-full">
            </article>
            <div class="flex flex-col w-full gap-2">
                <button class="primary-button">Update</button>
                <a href="/fieldworker/events-programs/birthday-cash-gifts" class="w-full p-2 rounded-lg text-xs bg-red-700 text-center text-white">Back</a>
            </div>
        </form>
    </section>
</x-dashboard-layout>