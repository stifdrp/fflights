@extends('laravel-usp-theme::master')

@section('title') FFLights @endsection

@section('content')
@can('financer')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="box justify-content-center container-sm">
    <div class="box-header with-border d-flex justify-content-between">
        <h4 class="box-title">{{$ticket->order->description}}</h4>
    </div>

    <div class="container">
            <fieldset>
                <div class="row">
                    <h6>Identificação</h6>
                </div>

                <div class="row">
                    <div class="col-4">
                        <p><b>Número USP: </b>{{ $ticket->uspNumber ?? ''}}</p>
                    </div>
                    <div class="col">
                        <p><b>Nome do passageiro:</b> {{ $ticket->passangerFullName ?? ''}}</p>
                    </div>
                </div>

                <div class="row">
                    <h6>Dados adicionais</h6>
                </div>
                <div class="row">
                    <div class="col">
                        <p><b>Passagem internacional:</b> {{ $ticket->international ? 'Sim' : 'Não'}}</p>
                    </div>
                    @isset($ticket->passport)
                    <div class="col">
                        <a href="{{route('ticket.passport.download', ['ticket' => $ticket])}}" class="btn btn-primary active" role="button" aria-pressed="true">Passaporte</a>
                    </div>
                    @endisset
                </div>

                <div class="row mb-2">
                    <h6>Dados do(s) trecho(s)</h6>
                </div>
                @foreach ($ticket->flightSegments as $segment)

                    <div class="row align-items-center mb-2">
                        <div class="col">
                            <b>Aeroporto de saída:</b> {{ $segment->fromAirportCode ?? ''}}
                        </div>
                        <div class="col">
                            <b>Aeroporto de chegada:</b> {{ $segment->toAirportCode ?? ''}}
                        </div>
                        <div class="col-1">
                            <b>Data de embarque:</b> {{ date('d/m/Y', strtotime($segment->departDate)) ?? ''}}
                        </div>
                        <div class="col-1">
                            <b>Hora do embarque:</b> {{ date('H:i', strtotime($segment->departTime)) ?? ''}}
                        </div>
                        <div class="col-1">
                            <a href="{{route('ticket.fs', ['ticket' => $ticket, 'flightSegment' => $segment])}}">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </a>
                        </div>
                        <div class="col-1">
                            <button type="button" class="btn editFS" data-toggle="modal"  
                                data-attr="{{route('ticket.fs.get', ['ticket' => $ticket, 'flightSegment' => $segment ?? '' ])}}"
                                data-target="#trecho" data-id="{{ $segment->id }}">
                                <i class="fas fa-file-invoice-dollar" style="color: red"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

            </fieldset>
        </div>

        
        <div class="modal fade" id="trecho" tabindex="-1" style="z-index: 1050; display:none" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header text-write">
                  <h5 class="modal-title">Valores</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                  </button>
                </div>
                <form id="formQuoteSegment" method="POST" action="">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="price">Valor da passagem</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('price') is-invalid @enderror"
                                        id="price"  name="price" value="">
                                </div>
                            </div>
                    
                            <div class="form-group col">
                                <label for="boardingTax">Taxa de embarque</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('boardingTax') is-invalid @enderror"
                                        id="boardingTax"  name="boardingTax" value="">
                                </div>
                            </div>
                    
                            <div class="form-group col">
                                <label for="agencyTax">Taxa de agenciamento</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('agencyTax') is-invalid @enderror"
                                        id="agencyTax"  name="agencyTax" value="">
                                </div>
                            </div>
                    
                            <div class="form-group col">
                                <label for="discount">Desconto</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('discount') is-invalid @enderror"
                                        id="discount"  name="discount" value="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
              </div>
            </div>
        </div>

        <div class="box-footer mt-3">
            <div class="row justify-content-between no-gutters">
                @isset($ticket)
                    @if($ticket->order->inProgress())
                        <div class="col-auto mr-auto mx-auto">
                            <button type="submit" class="btn btn-primary btn-block">
                                    Atualizar
                            </button>
                        </div>
                    @endif
                    <div class="col-auto mr-auto mx-auto">
                        <a class="btn btn-info btn-close" href="{{ route('order.show', ['order' => $ticket->order]) }}">Voltar</a>
                    </div>
                @endisset
            </div>
        </div>
    

    </div>
</div>
@endcan
@endsection
@section('javascripts_bottom')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script>
    // $(document).on("keypress", 'form', function (e) {
    //     var code = e.keyCode || e.which;
    //     if (code == 13) {
    //         e.preventDefault();
    //         return false;
    //     }
    // });
    $(document).ready(function () {
        $('.editFS').click( function() {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                type:"GET",
                dataType:"json",
                // return the result
                success: function(result) {
                    $('#price').val(result.data.price.replace(".", ","));
                    $('#boardingTax').val(result.data.boardingTax.replace(".", ","));
                    $('#agencyTax').val(result.data.agencyTax.replace(".", ","));
                    $('#discount').val(result.data.discount.replace(".", ","));
                    $('#formQuoteSegment').attr('action','/solicitation/ticket/'+ result.data.ticket_id +'/quote/'+ result.data.id );
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                },
                timeout: 8000
            })


        });
        bsCustomFileInput.init();
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
    });
</script>
@endsection
