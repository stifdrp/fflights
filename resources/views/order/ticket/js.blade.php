@section('javascripts_bottom')
@parent
<script>
    $(document).on("keypress", 'form', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });
    
    @isset($ticket)
        var i = {{count($ticket->flightSegments)}};
    @else
        var i = 0; 
    @endisset
    
    $("#addFlightSegment").click(function(){
        ++i;
        var html = '';
        var fromAirportCode = document.getElementById('fromAirportCode');
        var toAirportCode = document.getElementById('toAirportCode');
        var departDate = document.getElementById('departDate');
        html += '<tr id="row'+ i +'">';
        html += '<td>';
        html += '<input type="text" class="form-control" ';
        html += 'name="addmore['+i+'][fromAirportCode]"';
        html += 'value="'+ fromAirportCode.value +'"';
        html += 'maxlength="3" required>';
        html += '</td><td>';
        html += '<input type="text" class="form-control"';
        html += 'name="addmore['+i+'][toAirportCode]"';
        html += 'value="'+ toAirportCode.value +'"';
        html += 'maxlength="3" required>';
        html += '</td><td>';
        html += '<input type="datetime-local" class="form-control" ';
        html += 'name="addmore['+i+'][departDate]" max="9999-12-31T23:59" ';
        html += 'value="'+ departDate.value +'"';
        html += 'required >';
        html += '</td><td>';
        html += '<input name="addmore['+i+'][id]" type="hidden" value="" >';
        html += '<button id="'+i+'" class="btn btn-danger remove-tr btn-sm" >Remover</button>';
        html += '</td></tr>';
        $("#dynamic_fields").append(html);
        fromAirportCode.value = '';
        toAirportCode.value = '';
        departDate.value = '';
    });
    
    $(document).on('click', '.remove-tr', function(){  
        var button_id = $(this).attr("id");
        $("#row"+button_id+"").remove();
    });  
    </script>
@endsection