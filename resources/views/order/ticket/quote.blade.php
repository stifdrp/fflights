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
@include('order.ticket.flightSegment')

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
                            <b>Data de embarque:</b> {{ date('d/m/Y H:i', strtotime($segment->departDate)) ?? ''}}
                        </div>
                        {{-- <div class="col-1">
                            <a href="{{route('ticket.fs', ['ticket' => $ticket, 'flightSegment' => $segment])}}">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </a>
                        </div> --}}
                        <div class="col-1">
                            <button id="editFS" type="button" class="btn" data-toggle="modal" data-target="#trecho" data-id="{{ $segment->id }}">
                                <i class="fas fa-file-invoice-dollar" style="color: red"></i>
                            </button>
                        </div>
                    </div>
                @endforeach

            </fieldset>
        </div>

        {{-- <div class="modal fade" id="trecho" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalLabel">Valores</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col">
                                <label for="price">Valor da passagem</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('price') is-invalid @enderror"
                                        id="price"  name="price" value="{{ $ticket->price ?? old('price') }}">
                                </div>
                            </div>
                    
                            <div class="form-group col">
                                <label for="boardingTax">Taxa de embarque</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('boardingTax') is-invalid @enderror"
                                        id="boardingTax"  name="boardingTax" value="{{ $ticket->boardingTax ?? old('boardingTax') }}">
                                </div>
                            </div>
                    
                            <div class="form-group col">
                                <label for="agencyTax">Taxa de agenciamento</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('agencyTax') is-invalid @enderror"
                                        id="agencyTax"  name="agencyTax" value="{{ $ticket->agencyTax ?? old('agencyTax') }}">
                                </div>
                            </div>
                    
                            <div class="form-group col">
                                <label for="discount">Desconto</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">R$</span>
                                    </div>
                                    <input type="text" class="form-control money @error('discount') is-invalid @enderror"
                                        id="discount"  name="discount" value="{{ $ticket->discount ?? old('discount') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
        </div> --}}

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

                // $.ajaxSetup({
                //     headers: {
                //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });

                
                // $('#trecho').on('show.bs.modal', function (event){
                //     event.preventDefault();
                //     $.get({{route('ticket.fs', ['ticket' => $ticket, 'flightSegment' => $segment])}}, function(data){
                //         $('#trecho').html(data.ticket.passangerFullName);
                    
                // })

                bsCustomFileInput.init();
                $('.money').mask('000.000.000.000.000,00', {reverse: true});
            });
        </script>
    </div>
</div>
@endcan
@endsection
