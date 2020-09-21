<div class="box-body justify-content-center">
    <fieldset>
        <legend>Passagem</legend>
        <div class="form-row">
            <div class="form-group col-3">
                <label for="uspNumber">Número USP</label>
                <input type="number" class="form-control"
                    id="uspNumber"  name="uspNumber" value="{{ $ticket->uspNumber ?? old('uspNumber') }}">
            </div>
            <div class="form-group col">
                <label for="passangerFullName">Nome completo do passageiro</label>
                <input type="text" class="form-control"
                    id="passangerFullName" name="passangerFullName" value="{{ $ticket->passangerFullName ?? old('passangerFullName')  }}">
            </div>
        </div>


        <fieldset>
            <legend><h6>Dados para Chegada</h6></legend>
            <div class="form-row">
                <div class="form-group col">
                    <label for="incomingFromAirportCode">Aeroporto de saída</label>
                    <input type="text"
                        class="form-control"
                        id="incomingFromAirportCode"
                        name="incomingFromAirportCode"
                        value="{{ $ticket->incomingFromAirportCode ?? old('incomingFromAirportCode')  }}"
                        maxlength="3"
                    >
                </div>
                <div class="form-group col">
                    <label for="incomingToAirportCode">Aeroporto de chegada</label>
                    <input type="text"
                        class="form-control"
                        id="incomingToAirportCode"
                        name="incomingToAirportCode"
                        value="{{ $ticket->incomingToAirportCode ?? old('incomingToAirportCode')  }}"
                        maxlength="3"
                    >
                </div>

                <div class="form-group col">
                    <label for="dateDepartDate">Data de embarque</label>
                    <input type="date"
                        class="form-control"
                        name="dateDepartDate"
                        value=""
                    >
                </div>

                <div class="form-group col">
                    <label for="timeDepartDate">Hora de embarque</label>
                    <input type="time"
                        class="form-control"
                        name="timeDepartDate"
                        value=""
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
                        class="form-control"
                        id="outcomingFromAirportCode"
                        name="outcomingFromAirportCode"
                        value="{{ $ticket->outcomingFromAirportCode ?? old('outcomingFromAirportCode')  }}"
                        maxlength="3"
                    >
                </div>
                <div class="form-group col">
                    <label for="outcomingToAirportCode">Aeroporto de chegada</label>
                    <input type="text"
                        class="form-control"
                        id="outcomingToAirportCode"
                        name="outcomingToAirportCode"
                        value="{{ $ticket->outcomingToAirportCode ?? old('outcomingToAirportCode')  }}"
                        maxlength="3"
                    >
                </div>

                <div class="form-group col">
                    <label for="dateReturnDate">Data de embarque</label>
                    <input type="date"
                        class="form-control"
                        name="dateReturnDate"
                        value=""
                    >
                </div>

                <div class="form-group col">
                    <label for="timeReturnDate">Hora de embarque</label>
                    <input type="time"
                        class="form-control"
                        name="timeReturnDate"
                        value=""
                    >
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend><h6>Dados Adicionais</h6></legend>
            <div class="form-row">
                <div class="form-group col-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="international" id="international">
                        <label class="form-check-label" for="international">Passagem internacional</label>
                    </div>
                </div>

                <div class="custom-file col">
                    <input type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile" data-browse="Selecionar Arquivo">Passaporte</label>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend><h6>Dados Financeiros</h6></legend>
            <div class="form-row">
                <div class="form-group col">
                    <label for="price">Valor da passagem</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input type="number" class="form-control"
                            id="price"  name="price" value="{{ $ticket->price ?? old('price') }}">
                    </div>
                </div>

                <div class="form-group col">
                    <label for="boardingTax">Taxa de embarque</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input type="number" class="form-control"
                            id="boardingTax"  name="boardingTax" value="{{ $ticket->boardingTax ?? old('boardingTax') }}">
                    </div>
                </div>

                <div class="form-group col">
                    <label for="agencyTax">Taxa de agenciamento</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">R$</span>
                        </div>
                        <input type="number" class="form-control"
                            id="agencyTax"  name="agencyTax" value="{{ $ticket->agencyTax ?? old('agencyTax') }}">
                    </div>
                </div>

        </fieldset>


    </fieldset>

</div>
<!-- /.box-body -->

<div class="box-footer">
    <button type="submit" class="btn btn-primary">
        @empty($budget)
            Adicionar
        @else
            Atualizar
        @endempty
    </button>
</div>


