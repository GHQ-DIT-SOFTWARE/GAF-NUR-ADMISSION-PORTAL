<div class="dt-responsive table-responsive">
    <table id="simpletable" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th scope="col" style="width:2px;">#</th>
                <th scope="col">Post Type</th>
                <th scope="col">Post From</th>
                <th scope="col">Post To</th>
                <th scope="col">WEF</th>
                <th scope="col">End Date</th>
                <th scope="col">Appointment</th>
                <th scope="col">Appointment Type</th>
                <th scope="col">Authority/Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personnel->postings as $key => $post)
                <tr>
                    <td>{{ $key + 1 }}.</td>
                    <td>{{ $post->post_type }}</td>
                    <td>{{ $post->posted_from->unit }}
                    </td>
                    <td>{{ $post->posted_to->unit }}</td>
                    <td>{{ $post->wef_date }}</td>
                    <td>{{ $post->end_date }}</td>
                    <td>{{ $post->appointment?->appointment }}</td>
                    <td>{{ $post->appointment_type }}</td>
                    <td>{{ $post->authority_remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
