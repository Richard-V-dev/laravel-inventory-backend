<div class="container">
    <h1>List of saling/purchasing notes</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>DATE</th>
                <th>NOTE TYPE</th>
                <th>CLIENT/PROVIDER</th>
                <th>TAXES</th>
                <th>DISCOUNTS</th>
                <th>USER</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
                <tr>
                    <td>{{ $note['id'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($note['date'])->format('d/m/Y') }}</td>
                    <td>{{ $note['note_type'] }}</td>
                    <td>{{ $note['client']['company_name'] }}</td>
                    <td>{{ $note['taxes'] }}</td>
                    <td>{{ $note['discounts'] }}</td>
                    <td>{{ $note['user']['name'] }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>
</div>

<style>
    table{
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    table, th, td{
        border: 1px solid #ddd;
    }

    th, td{
        padding: 8px;
        text-align: center;
    }
</style>