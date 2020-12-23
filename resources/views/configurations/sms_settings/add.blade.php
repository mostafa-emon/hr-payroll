@extends('layouts.master')

@section('content')

  <div class="row mb-2">
      <div class="col-sm-6"></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{url('/')}}" style="color:#6c757d; font-weight: bold">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{url('/sms-settings')}}" style="color:#6c757d;">SMS Settings</a></li>
        </ol>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
              @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session()->get('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
              <form id="form" action="{{url('sms-settings-submit')}}" method="POST">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1" style="font-size:14px;color:#3b5998;">URL</label>
                        <input type="text" class="form-control" name="sms_api_url" value="{{ old('sms_api_url') }}" placeholder="URL" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Send to parameter</label>
                        <select class="form-control" name="send_to_parameter_name" required>
                          <option value="" selected>-- select parameter --</option>
                          <option value="parameter_1" @if(old('send_to_parameter_name') == "parameter_1") selected @endif>Parameter 1</option>
                          <option value="parameter_2" @if(old('send_to_parameter_name') == "parameter_2") selected @endif>Parameter 2</option>
                          <option value="parameter_3" @if(old('send_to_parameter_name') == "parameter_3") selected @endif>Parameter 3</option>
                          <option value="parameter_4" @if(old('send_to_parameter_name') == "parameter_4") selected @endif>Parameter 4</option>
                          <option value="parameter_5" @if(old('send_to_parameter_name') == "parameter_5") selected @endif>Parameter 5</option>
                          <option value="parameter_6" @if(old('send_to_parameter_name') == "parameter_6") selected @endif>Parameter 6</option>
                          <option value="parameter_7" @if(old('send_to_parameter_name') == "parameter_7") selected @endif>Parameter 7</option>
                          <option value="parameter_8" @if(old('send_to_parameter_name') == "parameter_8") selected @endif>Parameter 8</option>
                          <option value="parameter_9" @if(old('send_to_parameter_name') == "parameter_9") selected @endif>Parameter 9</option>
                          <option value="parameter_10" @if(old('send_to_parameter_name') == "parameter_10") selected @endif>Parameter 10</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Message body parameter</label>
                        <select class="form-control" name="sms_body_parameter_name" required>
                          <option value="" selected>-- select parameter --</option>
                          <option value="parameter_1" @if(old('sms_body_parameter_name') == "parameter_1") selected @endif>Parameter 1</option>
                          <option value="parameter_2" @if(old('sms_body_parameter_name') == "parameter_2") selected @endif>Parameter 2</option>
                          <option value="parameter_3" @if(old('sms_body_parameter_name') == "parameter_3") selected @endif>Parameter 3</option>
                          <option value="parameter_4" @if(old('sms_body_parameter_name') == "parameter_4") selected @endif>Parameter 4</option>
                          <option value="parameter_5" @if(old('sms_body_parameter_name') == "parameter_5") selected @endif>Parameter 5</option>
                          <option value="parameter_6" @if(old('sms_body_parameter_name') == "parameter_6") selected @endif>Parameter 6</option>
                          <option value="parameter_7" @if(old('sms_body_parameter_name') == "parameter_7") selected @endif>Parameter 7</option>
                          <option value="parameter_8" @if(old('sms_body_parameter_name') == "parameter_8") selected @endif>Parameter 8</option>
                          <option value="parameter_9" @if(old('sms_body_parameter_name') == "parameter_9") selected @endif>Parameter 9</option>
                          <option value="parameter_10" @if(old('sms_body_parameter_name') == "parameter_10") selected @endif>Parameter 10</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 1 Key</label>
                        <input type="text" class="form-control" name="parameter_1_key" value="{{ old('parameter_1_key') }}" placeholder="Parameter 1 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 2 Key</label>
                        <input type="text" class="form-control" name="parameter_2_key" value="{{ old('parameter_2_key') }}" placeholder="Parameter 2 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 3 Key</label>
                        <input type="text" class="form-control" name="parameter_3_key" value="{{ old('parameter_3_key') }}" placeholder="Parameter 3 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 4 Key</label>
                        <input type="text" class="form-control" name="parameter_4_key" value="{{ old('parameter_4_key') }}" placeholder="Parameter 4 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 5 Key</label>
                        <input type="text" class="form-control" name="parameter_5_key" value="{{ old('parameter_5_key') }}" placeholder="Parameter 5 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 6 Key</label>
                        <input type="text" class="form-control" name="parameter_6_key" value="{{ old('parameter_6_key') }}" placeholder="Parameter 6 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 7 Key</label>
                        <input type="text" class="form-control" name="parameter_7_key" value="{{ old('parameter_7_key') }}" placeholder="Parameter 7 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 8 Key</label>
                        <input type="text" class="form-control" name="parameter_8_key" value="{{ old('parameter_8_key') }}" placeholder="Parameter 8 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 9 Key</label>
                        <input type="text" class="form-control" name="parameter_9_key" value="{{ old('parameter_9_key') }}" placeholder="Parameter 9 Key">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 10 Key</label>
                        <input type="text" class="form-control" name="parameter_10_key" value="{{ old('parameter_10_key') }}" placeholder="Parameter 10 Key">
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 1 Value</label>
                          <input type="text" class="form-control" name="parameter_1_value" value="{{ old('parameter_1_value') }}" placeholder="Parameter 1 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 2 Value</label>
                          <input type="text" class="form-control" name="parameter_2_value" value="{{ old('parameter_2_value') }}" placeholder="Parameter 2 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 3 Value</label>
                          <input type="text" class="form-control" name="parameter_3_value" value="{{ old('parameter_3_value') }}" placeholder="Parameter 3 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 4 Value</label>
                          <input type="text" class="form-control" name="parameter_4_value" value="{{ old('parameter_4_value') }}" placeholder="Parameter 4 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 5 Value</label>
                          <input type="text" class="form-control" name="parameter_5_value" value="{{ old('parameter_5_value') }}" placeholder="Parameter 5 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 6 Value</label>
                          <input type="text" class="form-control" name="parameter_6_value" value="{{ old('parameter_6_value') }}" placeholder="Parameter 6 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 7 Value</label>
                          <input type="text" class="form-control" name="parameter_7_value" value="{{ old('parameter_7_value') }}" placeholder="Parameter 7 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 8 Value</label>
                          <input type="text" class="form-control" name="parameter_8_value" value="{{ old('parameter_8_value') }}" placeholder="Parameter 8 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 9 Value</label>
                          <input type="text" class="form-control" name="parameter_9_value" value="{{ old('parameter_9_value') }}" placeholder="Parameter 9 Value">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword1" style="font-size:14px;color:#3b5998;">Parameter 10 Value</label>
                          <input type="text" class="form-control" name="parameter_10_value" value="{{ old('parameter_10_value') }}" placeholder="Parameter 10 Value">
                        </div>
                      </div>
                    </div>
                    <div class="form-group mb-0 mt-3 justify-content-end">
                      <input type="hidden" name="job" id="job"/>
                      <div class="row">
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="settings_title" value="{{ old('settings_title') }}" placeholder="Settings Title"/>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-md-12">
                          <a class="btn btn-primary text-white" onclick="updateSettings()">Save</a>
                          <a class="btn btn-success text-white" onclick="sendTestSMS()">Send Test SMS</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                


              </form>
            </div>
        </div>
    </div>
  </div>

<script>
  function updateSettings(){
    $('#job').val('save_settings');
    $('#form').submit();
  }

  function sendTestSMS(){
    $('#job').val('send_test_sms');
    $('#form').submit();
  }
</script>
@endsection