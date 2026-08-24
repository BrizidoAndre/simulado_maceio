<x-layout-admin>
    <h1>Contacts</h1>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Content</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($contacts as $contact)
            <tr>
                <td>{{$contact->name}}</td>
                <td>{{$contact->email}}</td>
                <td>{{$contact->message}}</td>
                <td>{{$contact->created_at->diffForHumans()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout-admin>
