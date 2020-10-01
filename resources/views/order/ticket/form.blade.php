<div class="box-body justify-content-center">
    <fieldset
        @isset($ticket)
            @if($ticket->order->status != 'E')
                disabled
            @endif
        @endisset
    >
        <legend>Passagem</legend>
        <div class="form-row">
            <div class="form-group col-3">
                <label for="uspNumber">Número USP</label>
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
            <legend><h6>Dados para Chegada</h6></legend>
            <div class="form-row">
                <div class="form-group col">
                    <label for="incomingFromAirportCode">Aeroporto de saída</label>
                    <input type="text"
                        class="form-control @error('incomingFromAirportCode') is-invalid @enderror"
                        id="incomingFromAirportCode"
                        name="incomingFromAirportCode"
                        value="{{ $ticket->incomingFromAirportCode ?? old('incomingFromAirportCode')  }}"
                        maxlength="3"
                        required
                    >
                </div>
                <div class="form-group col">
                    <label for="incomingToAirportCode">Aeroporto de chegada</label>
                    <input type="text"
                        class="form-control @error('incomingToAirportCode') is-invalid @enderror"
                        id="incomingToAirportCode"
                        name="incomingToAirportCode"
                        value="{{ $ticket->incomingToAirportCode ?? old('incomingToAirportCode')  }}"
                        maxlength="3"
                        required
                    >
                </div>

                <div class="form-group col">
                    <label for="departDate">Data e hora de embarque</label>
                    <input type="datetime-local"
                        class="form-control @error('departDate') is-invalid @enderror"
                        name="departDate"
                        max="9999-12-31T23:59"
                        @isset($ticket->departDate)
                            value="{{ date('Y-m-d\TH:i:s', strtotime($ticket->departDate)) ?? old('departDate') }}"
                        @else
                            value="{{old('departDate') ?? ''}}"
                        @endisset
                        required
                    >
                </div>

            </div>
        </fieldset>


        <fieldset>
            <legend><h6>Dados para Retorno</h6></legend>
            <div class="form-row">
                <div class="form-group col">
                    <label for="outcomingFromAirportCode">Aeroporto de saída</label>
                    <input type="text"
                        class="form-control @error('outcomingFromAirportCode') is-invalid @enderror"
                        id="outcomingFromAirportCode"
                        name="outcomingFromAirportCode"
                        value="{{ $ticket->outcomingFromAirportCode ?? old('outcomingFromAirportCode')  }}"
                        maxlength="3"
                        required
                    >
                </div>
                <div class="form-group col">
                    <label for="outcomingToAirportCode">Aeroporto de chegada</label>
                    <input type="text"
                        class="form-control @error('outcomingToAirportCode') is-invalid @enderror"
                        id="outcomingToAirportCode"
                        name="outcomingToAirportCode"
                        value="{{ $ticket->outcomingToAirportCode ?? old('outcomingToAirportCode')  }}"
                        maxlength="3"
                        required
                    >
                </div>

                <div class="form-group col">
                    <label for="returnDate">Data e hora de embarque</label>
                    <input type="datetime-local"
                        class="form-control @error('returnDate') is-invalid @enderror"
                        name="returnDate"
                        max="9999-12-31T23:59"
                        @isset($ticket->departDate)
                            value="{{ date('Y-m-d\TH:i:s', strtotime($ticket->returnDate)) ?? old('returnDate') }}"
                        @else
                            value="{{old('returnDate') ?? ''}}"
                        @endisset
                        required
                    >
                </div>

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

        @can('financer')
        <fieldset>
            <legend><h6>Dados Financeiros</h6></legend>
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

        </fieldset>
        @endcan
    </fieldset>

</div>
<!-- /.box-body -->

<div class="box-footer">
    <div class="row justify-content-between no-gutters">
        @isset($order)
            @if($order->status == 'E')
                <div class="col-auto mr-auto mx-auto">
                    <button type="submit" class="btn btn-primary btn-block">
                            Adicionar
                    </button>
                </div>
            @endif
            <div class="col-auto mr-auto mx-auto">
                <a class="btn btn-info btn-close" href="{{ route('order.show', ['order' => $order]) }}">Voltar</a>
            </div>
        @endisset

        @isset($ticket)
            @if($ticket->order->status == 'E')
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
    $(document).ready(function () {
        bsCustomFileInput.init();
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
    });
  </script>
