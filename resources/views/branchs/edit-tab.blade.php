<form action="{{ route('branchs.update', [$branch]) }}" method="POST" class="col-md-12 form-horizontal" novalidate>
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group {{ $errors->has('branch_name') ? 'has-error' : '' }}">
        <label class="col-sm-2 control-label">Branch Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Branch Name" name="branch_name" value="{{ $branch->ShortName }}"
                {{ \Auth::user()->checkAccessById(3, "E") ? "" : "readonly" }}>
            @if($errors->has('branch_name'))
            <span class="help-block">{{ $errors->first('branch_name') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('operator') ? 'has-error' : '' }}">
        <label class="col-sm-2 control-label">Operator</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Operator" name="operator" value="{{ $branch->Description }}" 
                {{ \Auth::user()->checkAccessById(3, "E") ? "" : "readonly" }}>
            @if($errors->has('operator'))
            <span class="help-block">{{ $errors->first('operator') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('street') ? 'has-error' : '' }}">
        <label class="col-sm-2 control-label">Street Address</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Street Address" name="street" value="{{ $branch->Street }}"
                {{ \Auth::user()->checkAccessById(3, "E") ? "" : "readonly" }}>
            @if($errors->has('street'))
            <span class="help-block">{{ $errors->first('street') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('province') ? 'has-error' : '' }}">
        <label class="col-sm-2 control-label">Province</label>
        <div class="col-sm-10">
            <select name="province" id="select-province" class="form-control" 
                {{ \Auth::user()->checkAccessById(3, "E") ? "" : "readonly" }}>
                <option selected>Select Province</option>
                @foreach(\App\Province::all() as $province)
                    @if($branch->city && $branch->city->province)
                        <option value="{{ $province->Prov_ID }}" {{ $branch->city->province->Prov_ID == $province->Prov_ID ? 'selected' : ''}}>{{ $province->Province }}</option>
                    @else
                        <option value="{{ $province->Prov_ID }}">{{ $province->Province }}</option>
                    @endif
                @endforeach
            </select>
            @if($errors->has('province'))
            <span class="help-block">{{ $errors->first('province') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
        <label class="col-sm-2 control-label">City</label>
        <div class="col-sm-10">
            <select name="city" id="select-city" class="form-control" 
                {{ \Auth::user()->checkAccessById(3, "E") ? "" : "readonly" }}>
                <option selected>Select City</option>
                @foreach(\App\City::all() as $city)
                    <option data-province="{{ $city->province->Prov_ID }}" value="{{ $city->City_ID }}"
                        {{ $branch->city->City_ID == $city->City_ID ? 'selected' : ''}}>{{ $city->City }}</option>
                @endforeach
            </select>
            @if($errors->has('city'))
            <span class="help-block">{{ $errors->first('city') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('units') ? 'has-error' : '' }}" >
        <label class="col-sm-2 control-label">No. Of Units</label>
        <div class="col-sm-10">
            <input type="number" name="units" class="form-control" placeholder="No. Of Units" value="{{ $branch->MaxUnits }}"
                {{ \Auth::user()->checkAccessById(3, "E") ? "" : "readonly" }}>
            @if($errors->has('units'))
            <span class="help-block">{{ $errors->first('units') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Active</label>
        <div class="col-sm-10">
            <div class="control-checkbox">
                <input type="checkbox" id="brand-active" name="active" {{ $branch->Active == 1 ? 'checked' : ''}} value="1">
                <label for="{{ \Auth::user()->checkAccessById(3, "E") ? "brand-active" : "" }}">Active</label>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="col-md-12">
            <a href="{{ route('branchs.index', ['corpID' => $branch->corp_id]) }}" class="btn btn-default pull-left">
                <i class="fa fa-reply"></i> Back
            </a>
            @if(\Auth::user()->checkAccessById(3, "E"))
                <button type="submit" class="btn btn-success pull-right">Update</button>
            @endif
        </div>
    </div>
</form>