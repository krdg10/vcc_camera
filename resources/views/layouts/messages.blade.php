@if ($errors->any())
    @foreach ($errors->all() as $error)
        <span class="badge badge-danger badge-pill">
            {{ $error }}
        </span>
    @endforeach
@endif
@if( \Session::has('error') )
    <span id="danger" class="badge badge-danger badge-pill">
        {{ \Session::get('error') }}
    </span>
@endif
@if( \Session::has('message') )
    <span id="success" class="badge badge-success badge-pill">
        {{ \Session::get('message') }}
            <a id="excluir" onClick="excluirElement('success')"><i class="fa fa-times" aria-hidden="true"></i></a>
    </span>
@endif