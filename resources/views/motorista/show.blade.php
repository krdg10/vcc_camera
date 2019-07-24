@extends('motorista.layoutTabela')

@section('tagsMotorista')
    <script type="text/javascript">
        var metodos;
        window.onload = function(){
                metodos = new Metodos('metodos', '{{csrf_token()}}');

            @if( \Session::has('error') )
                @foreach(session()->get('error') as $key => $ms)
                    metodos.msgError('{{ $ms }}', 'divMsg');
                @endforeach
            @endif
            @if( Session::has('message') )
                metodos.msgSuccess('{{ \Session::get('message') }}', 'divMsg');
            @endif
        }
    </script>

    {{-- DIV PARA EXIBIR MENSAGENS. --}}
    <div id="divMsg"></div>
@endsection

@section('footerMotorista')
    <div id="formFooter">
        <div class="d-flex justify-content-center">
            {{ $motoristas->links() }}
        </div>
    </div>
@endsection 