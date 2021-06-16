<div class="box-body justify-content-center">
    <fieldset
        @isset($ticket)
            @if(!$ticket->order->inElaboration())
                disabled
            @endif
        @endisset
    >
        <legend>Passagem</legend>
        <div class="form-row">
            <div class="form-group col-3">
                <label for="uspNumber">Número USP do passageiro</label>
                <input type="number" class="form-control @error('uspNumber') is-invalid @enderror"
                    id="uspNumber"  name="uspNumber" value="{{ $ticket->uspNumber ?? old('uspNumber') }}">
            </div>
            <div class="form-group col">
                <label for="passangerFullName">Nome completo do passageiro</label>
                <input type="text" class="form-control @error('passangerFullName') is-invalid @enderror"
                    id="passangerFullName" name="passangerFullName" value="{{ $ticket->passangerFullName ?? old('passangerFullName')  }}" required>
            </div>
        </div>


        <fieldset>
            <legend>Dados do trecho</legend>

            <div class="form-row">
                <div class="form-group col">
                    <label for="fromAirportCode">Sigla do aeroporto de saída</label>
                    <input type="text"
                        id="fromAirportCode"
                        class="form-control"
                        name="fromAirportCode"
                        maxlength="3"
                    >
                </div>
                <div class="form-group col">
                    <label for="toAirportCode">Sigla do aeroporto de chegada</label>
                    <input type="text"
                        class="form-control"
                        id="toAirportCode"
                        name="toAirportCode"
                        maxlength="3"
                    >
                </div>

                <div class="form-group col">
                    <label for="departDate">Data e hora de embarque</label>
                    <input type="datetime-local"
                        class="form-control"
                        id="departDate"
                        name="departDate"
                        max="9999-12-31T23:59"
                    >
                </div>
                <div class="form-group col-1 align-items-end align-self-end mr-2">
                    <button type="button" id="addFlightSegment" class="btn btn-success btn" > Adicionar</button>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dynamic_fields">
                    <thead>
                        <tr>
                            <td>Sigla do aeroporto de saída</td>
                            <td>Sigla do aeroporto de chegada</td>
                            <td>Data e hora de embarque</td>
                            <td>Ação</td>
                        </tr>
                    </thead>
                    
                        @isset($ticket)
                            @if(count($ticket->flightSegments) > 0)
                                @foreach ($ticket->flightSegments as $key => $segment)
                                    <tr id="row{{$key}}">
                                        <td>
                                            <input type="text"
                                            class="form-control @error('addmore[{{$key}}][fromAirportCode]') is-invalid @enderror"
                                            name="addmore[{{$key}}][fromAirportCode]"
                                            value="{{ $ticket->flightSegments[$key]->fromAirportCode ?? old('addmore['.$key.'][fromAirportCode]')  }}"
                                            maxlength="3"
                                            required
                                        >
                                        </td>
                                        <td>
                                            <input type="text"
                                            class="form-control @error('addmore[{{$key}}][toAirportCode]') is-invalid @enderror"
                                            name="addmore[{{$key}}][toAirportCode]"
                                            value="{{ $ticket->flightSegments[$key]->toAirportCode ?? old('toAirportCode')  }}"
                                            maxlength="3"
                                            required
                                        >
                                        </td>
                                        <td>
                                            <input type="datetime-local"
                                            class="form-control @error('addmore[{{$key}}][departDate]') is-invalid @enderror"
                                            name="addmore[{{$key}}][departDate]"
                                            max="9999-12-31T23:59"
                                            @isset($ticket->flightSegments[$key]->departDate)
                                                value="{{ date('Y-m-d\TH:i:s', strtotime($ticket->flightSegments[$key]->departDate)) ?? old('departDate') }}"
                                            @else
                                                value="{{old('departDate') ?? ''}}"
                                            @endisset
                                            required
                                        >
                                        </td>
                                        <td>
                                            <input name="addmore[{{$key}}][id]" type="hidden" value="{{$ticket->flightSegments[$key]->id ?? '' }}" />
                                           
                                            <button id="{{$key}}" class="btn btn-danger remove-tr btn-sm" >Remover</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endisset
                    </tr>
                </table>
            </div>
        </fieldset>

        <fieldset>
            <legend><h6>Dados Adicionais</h6></legend>
            <div class="form-row justify-content-between">
                <div class="form-group col-3">
                    <div class="form-check">
                        <input type="checkbox"
                                class="form-check-input"
                                name="international"
                                id="international"
                                value=True
                                @isset($ticket)
                                    @if($ticket->international)
                                        checked
                                    @endif>
                                @endisset
                        <label class="form-check-label" for="international" >Passagem internacional</label>
                    </div>
                </div>

                <div class="custom-file col">
                    <input type="file" class="custom-file-input @error('passport') is-invalid @enderror" id="customFile" name="passport">
                    <label class="custom-file-label" for="customFile" data-browse="Selecionar Arquivo">Passaporte</label>
                </div>
                @isset($ticket->passport)
                    <div class="form-group col-1">
                        <a href="{{route('ticket.passport.download', ['ticket' => $ticket])}}" class="btn btn-primary active" role="button" aria-pressed="true">Passaporte</a>
                    </div>
                @endisset
            </div>
        </fieldset>

    </fieldset>

</div>
<!-- /.box-body -->

<div class="box-footer mt-3">
    <div class="row justify-content-between no-gutters">
        @isset($order)
            @if($order->inElaboration())
                <div class="col-auto mr-auto mx-auto">
                    <button id="submit" type="submit" class="btn btn-primary btn-block">
                            Adicionar
                    </button>
                </div>
            @endif
            <div class="col-auto mr-auto mx-auto">
                <a class="btn btn-info btn-close" href="{{ route('order.show', ['order' => $order]) }}">Voltar</a>
            </div>
        @endisset

        @isset($ticket)
            @if($ticket->order->inElaboration())
                <div class="col-auto mr-auto mx-auto">
                    <button id="submit" type="submit" class="btn btn-primary btn-block">
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