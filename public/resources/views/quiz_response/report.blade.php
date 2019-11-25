@extends('layouts.app')

@section('content')
<div class="">
    <h2>Laporan {{$polling->name}}
    <a class="btn btn-primary float-right" href="{{route('quiz.export_excel',[$polling->id])}}">Export</a></h2>
    <table class="table for_datatables">
    	<thead>
    		<tr>
	    		<th>Nama</th>
	    		<th>Dealer</th>
                @foreach(\App\PollingQuestion::where('polling_id',$polling->id)->get() as $key => $val)
                <th>Pertanyaan {{$key+1}}</th>
                @endforeach
                <th>Total</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Action</th>
	    	</tr>
    	</thead>
    	<tbody>
    		@foreach($polling_participant as $key)
            <?php $x = 0; ?>
    			<tr>
    				<td>{{$key->invitation->name}}</td>
                    <td>{{$key->invitation->company}}</td>
                    @foreach(\App\PollingQuestion::where('polling_id',$polling->id)->get() as $row => $val)
                        <?php $win = isset(\App\PollingResponse::where('polling_id',$polling->id)->where('invitation_id',$key->invitation->id)->where('polling_question_id',$val->id)->first()->is_winner)?\App\PollingResponse::where('polling_id',$polling->id)->where('invitation_id',$key->invitation->id)->where('polling_question_id',$val->id)->first()->is_winner:0;?>
                        <td>{{$win==1?'Benar':'Salah'}}</td>
                        <?php $x+= $win; ?>
                    @endforeach
                    <td>{{$x}}</td>
                    <td>{{$key->created_at}}</td>
                    <td>{{$key->is_winner==1?'Menang':'Tidak Menang'}}</td>
                    <td><a class="btn btn-danger" href="{{route('polling_response.reset',[$polling->id, $key->invitation->id])}}">Reset</a></td>
    			</tr>
    		@endforeach
    	</tbody>
    </table>
</div>
@endsection
