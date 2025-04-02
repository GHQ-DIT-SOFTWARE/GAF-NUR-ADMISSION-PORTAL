<div class="dt-responsive table-responsive">
    <table id="simpletable" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th scope="col" style="width:2px;">#</th>
                <th scope="col"> Type</th>
                <th scope="col">Description</th>
                <th scope="col">Medal</th>
                <th scope="col">Tour Numeral</th>
                <th scope="col">WEF Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Appointment</th>
                <th scope="col">Authority/Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personnel->externalOperations as $key => $operation)
                <tr>
                    <td>{{ $key + 1 }}.</td>
                    <td>{{ $operation->operation_type }}</td>
                    <td>{{ $operation->description }}</td>
                    <td>{{ $operation->medal }}</td>
                    <td>{{ $operation->tour_numeral != null ? 'Num "' . $operation->tour_numeral . '"' : '' }}
                    </td>
                    <td>{{ $operation->wef_date }}</td>
                    <td>{{ $operation->end_date }}</td>
                    <td>{{ $operation->appointment }}</td>
                    <td>{{ $operation->authority_remarks }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
