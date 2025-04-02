<div class="dt-responsive table-responsive">
    <table id="simpletable" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th scope="col" style="width:2px;">#</th>
                <th scope="col">Type</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Location</th>
                <th scope="col">Grade</th>
                <th scope="col">Course Name</th>
                <th scope="col">Institution</th>
                <th scope="col">Authority/Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personnel->courses as $key => $course)
                <tr>
                    <td>{{ $key + 1 }}.</td>
                    <td>{{ $course->course_type }}</td>
                    <td>{{ $course->start_date }}</td>
                    <td>{{ $course->end_date }}</td>
                    <td>{{ $course->location }}</td>
                    <td>{{ $course->grade }}</td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->institution }}</td>
                    <td>{{ $course->authority_remarks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
