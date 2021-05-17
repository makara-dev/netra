{{-- Custom style --}}
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

<p>&nbsp;</p>
<table class="blueTable">
<thead>
    <tr>
        <th >#Id</th>
        <th>Staff Note</th>
        <th>Quoatation Note</th>
        <th>Paid</th>
        <th>Total</th>
        <th>Payment Status</th>
        <th>Status</th>
        <th>Reference Number</th>
        <th>Date Time</th>
    </tr>
</thead>
<tfoot>
<tr>

</tr>
</tfoot>
<tbody>
    @foreach ($data as  $item)
    <tr>
        <td>#{{$item->id}}</td>
        <td>{{$item->staff_note}}</td>
        <td>{{$item->quotation_note}}</td>
        <td>{{$item->paid}} </td>
        <td>{{$item->total}}</td>
        <td>{{$item->payment_status}}</td>
        <td>{{$item->status}}</td>
        <td>{{$item->reference_num}}</td>
        <td>{{$item->datetime}}</td>
       
    </tr>
    @endforeach
</tbody>
</table>