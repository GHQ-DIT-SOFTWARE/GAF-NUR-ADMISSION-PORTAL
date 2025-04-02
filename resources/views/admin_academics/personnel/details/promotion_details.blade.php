<div class="dt-responsive table-responsive">
    <table id="simpletable" class="table table-striped table-bordered nowrap">
        <thead>
            <tr>
                <th scope="col" style="width:2px;">#</th>
                <th scope="col">Previous Rank</th>
                <th scope="col">Current Rank</th>
                <th scope="col">Promotion Type</th>
                <th scope="col">Effective Date</th>
                <th scope="col">Authority/Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personnel->promotions as $key => $promotion)
                <tr>
                    <td>{{ $key + 1 }}.</td>
                    <td>{{ $promotion->previous_rank[rank_conversion($promotion->personnel->arm_of_service)] }}
                    </td>
                    <td>{{ $promotion->promoted_rank[rank_conversion($promotion->personnel->arm_of_service)] }}
                    </td>
                    <td>{{ $promotion->promotion_type }}</td>
                    <td>{{ $promotion->effective_date }}</td>
                    <td>{{ $promotion->authority_remarks }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
