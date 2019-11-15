@extends('layouts.chart')

@section('content')
<div class="container">
	<br>
    <h3 class="text-center">{{$polling_question->content}}</h3>
    <hr>
	<canvas id="myChart"></canvas>


</div>
@endsection

@section('footer')
<script>

	var bgColor = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)'
        ],
        bdColor = [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ];
	var ctx = document.getElementById('myChart');
	
	<?php $i=0; ?>

	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	    	labels:[''],
	        datasets: [
	        @foreach($polling_response as $row)

	        {
	        	label:'{{$row->polling_answer->content}}',
	            data: [ '{{$row->total}}'  ],
	            backgroundColor:[bgColor[{{$i}}]],
	            borderColor:[bdColor[{{$i++}}]],
	            borderWidth: 1
	        },
	        
	        @endforeach

	        ]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        },
		    legend: {
		        display: true,
		        labels:{
		        	fontSize:25
		        },
		        align:'center',
		        position:'right'
		    }
	    }
	});
	</script>
@endsection