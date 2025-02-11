<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('head')
</head>
@extends('dashboard.main')

@section('contenido')


<div class="container-xl-6">
    <a href="{{ URL::previous() }}"><i class="fas fa-arrow-left"></i></a>
</div>

<body>

    <div class="container-fluid justify-content-between p-0" id="appp">
        <div class="container mb-4">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 contImagen">
                    <img src="{{asset('storage/Logos/horizontal_azulR.png')}}" id="LogoUaslpAgenda"
                        alt="Logo uaslp-Agenda Ambiental" srcset="">
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 ">
                    <div class="align-self-center" style="font-family:Myraid Pro Bold; ">
                        <h4 class="pt-5">Ficha técnica </h4>
                        <span> </span>
                    </div>
                </div>

            </div>
        </div>
        <div id="nosotros">
            @if(session()->has('message'))
            <div class="alert alert-success text-center">
                <h2>
                    {{session()->get('message') }}
                </h2>
            </div>
            @endif
            @if ($FichaTecnica->Estado=="Rechazada")
            <div class="container-fluid mx-0 mb-2">
                <div class="row justify-content-end">
                    <div class="col-auto text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Ver retroalimentación
                        </button>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLabel">Motivio de Rechazo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{$FichaTecnica->MotivoRechazo}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <form method="POST" action="{{route('EditarFT',['id'=>$FichaTecnica->id])}}" enctype="multipart/form-data">
                @csrf
                <div class="row row-cols-1 row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-2">
                    <div class="col mb-4 " v-for="(a, index) in archivos">
                        <div class="card w-100 ">
                            <h5 class="card-title text-center">@{{a.parteP}} </h5>

                            <div class="card-body">
                                <img class="card-img-top " v-if="a.imagen!=''" :id="a.nombre"
                                    :src="a.ban==false?'{{asset('storage/')}}'+a.imagen:a.imagen" alt="Card image cap">
                            </div>
                            <div class="card-footer pl-5">

                                <small class="text-muted">
                                    <input type="file" accept="image/png,image/jpeg" :id="'fileImg'+index"
                                        :name="'fileImg'+index" class="inp" @change="cargarImagen($event,index)" />
                                </small>
                            </div>
                        </div>
                    </div>


                </div>
                <p style="display: none;">
                    @foreach ($Ejemplar as $item)
                    @if ($item->id==$FichaTecnica->id)
                    {{$Nomb=$item->NombreComun}}
                    {{$NombC=$item->NombreCientifico}}
                    @endif
                    @endforeach
                </p>
                <div class="alert alert-warning text-right" role="alert">
                    <b>
                        La previsualización de las imagenes no representa la calidad real de las mismas.*
                    </b>
                </div>
              
                <div class="form-row justify-content-between">

                    <div class="col-xl-6">
                        <h2 class="alert alert-primary text-center">Datos generales</h2>
                        <x-typeInput labelFor="FechaRecoleccion" isRequiered="true" typeInput="date"
                            isReadOnly="{{boolval($isReO)}}" label="Fecha de recoleccion de datos" haveValue="{{true}}"
                            value="{{$FichaTecnica->FechaRecoleccion}}">
                        </x-typeInput>
                        <x-typeInput labelFor="FechaFotografia" isRequiered="true" typeInput="date"
                            isReadOnly="{{boolval($isReO)}}" label="Fecha de fotografía" haveValue="{{true}}"
                            value="{{$FichaTecnica->FechaRecoleccion}}">
                        </x-typeInput>
                        <x-typeInput labelFor="NombreRecolectorD" isRequiered="true" isReadOnly="{{boolval($isReO)}}"
                            label="Nombre del recolector de datos" haveValue="{{true}}"
                            value="{{$FichaTecnica->NombreRecolectorDatos}}">
                        </x-typeInput>
                        <x-typeInput labelFor="NombreRecolectorm" isRequiered="true" isReadOnly="{{boolval($isReO)}}"
                            label="Nombre del recolector de muestra" haveValue="{{true}}"
                            value="{{$FichaTecnica->NombreRecolectorMuestra}}">
                        </x-typeInput>
                        <x-typeInput labelFor="NombreAutorFoto" isRequiered="true" isReadOnly="{{boolval($isReO)}}"
                            label="Nombre de autor de fotografías" haveValue="{{true}}"
                            value="{{$FichaTecnica->NombreAutorFoto}}">

                        </x-typeInput>
                    </div>
                    <div class="col-xl-6">
                        <h2 class="alert alert-primary text-center">Caracteristicas de la especie</h2>
                        <div class="form-group row g-3 was-validated">
                            <label for="NombreC"
                                class="col-md-4 col-form-label text-md-left">{{ __('Nombre común') }}</label>
                            <div class="col-md-8">
                                <input id="NombreC" readonly type="text"
                                    class="form-control @error('NombreC') is-invalid @enderror" name="NombreC"
                                    maxlength="40" value={{$Nomb}} required autocomplete="NombreC" autofocus>
                                @error('NombreC')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row g-3 was-validated">
                            <label for="NombreCientifico"
                                class="col-md-4 col-form-label text-md-left">{{ __('Nombre científico') }}</label>
                            <div class="col-md-8">
                                <input id="NombreCientifico" readonly type="text"
                                    class="form-control @error('NombreCientifico') is-invalid @enderror"
                                    name="NombreCientifico" value={{$NombC}} maxlength="40" required
                                    autocomplete="NombreCientifico" autofocus>
                                @error('NombreCientifico')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <x-typeInput :labelFor="'PermanenciaHojas'" :isRequiered="true" :label="'Permanencia de hojas'"
                            haveValue="{{true}}" value="{{$FichaTecnica->TPertenencia}}"
                            isReadOnly="{{boolval($isReO)}}">
                        </x-typeInput>
                    </div>
                    <div class="col-12">
                        <h2 class="alert alert-primary text-center">Morfología y estado de fitosanitarios básicos</h2>
                        <div class="form-row">
                           
                                <div class="col-xl-6 ">
                                    <x-typeInput :labelFor="'FormaCrecimiento'" :isRequiered="true"
                                        :label="'Forma de crecimiento'" haveValue="{{true}}"
                                        value="{{$FichaTecnica->Fcrecimiento}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput labelFor="Floracion" :isRequiered="true" typeInput="text"
                                        label="Floración" isTextArea="true" haveValue="{{true}}"
                                        value="{{$FichaTecnica->Floracion}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>

                                    <x-typeInput :labelFor="'Origen'" :isRequiered="true" :label="'Origen'"
                                        haveValue="{{true}}" value="{{$FichaTecnica->Origen}}"
                                        isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput labelFor="Descripcion" :isRequiered="true" typeInput="text"
                                        label="Descripción" isTextArea="true" haveValue="{{true}}"
                                        value="{{$FichaTecnica->Descripcion}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput :labelFor="'EstatusEco'" :isRequiered="true"
                                        :label="'Estatus ecológico en México'" haveValue="{{true}}"
                                        value="{{$FichaTecnica->EstatusEco}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput :labelFor="'EstatusConser'" :isRequiered="true"
                                        :label="'Estatus de conservación'" haveValue="{{true}}"
                                        value="{{$FichaTecnica->EstatusConv}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput labelFor="Altura" typeInput="number" :isRequiered="true"
                                        label="Altura en estado natural (m)" haveValue="{{true}}"
                                        value="{{$FichaTecnica->Altura}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>

                                    <x-typeInput labelFor="AlturaCurbanas" typeInput="number" :isRequiered="true"
                                        label="Altura en condiciones urbanas (m)" haveValue="{{true}}"
                                        value="{{$FichaTecnica->Altura}}" isReadOnly="{{boolval($isReO)}}">

                                    </x-typeInput>
                                    <x-typeInput :labelFor="'TipoC'" :isRequiered="true" :label="'Tipo de copa'"
                                        haveValue="{{true}}" value="{{$FichaTecnica->TipoC}}"
                                        isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput :labelFor="'TipoR'" :isRequiered="true" :label="'Tipo de raíces'"
                                        haveValue="{{true}}" value="{{$FichaTecnica->TipoR}}"
                                        isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>


                                </div>
                                <div class="col-xl-6">
                                    <x-typeInput labelFor="RaicesObs" :isRequiered="true" typeInput="text"
                                        label="Raíces observables del ejemplar" isTextArea="true" haveValue="{{true}}"
                                        value="{{$FichaTecnica->RaicesObs}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput labelFor="Usos" :isRequiered="true" typeInput="text" label="Usos"
                                        isTextArea="true" haveValue="{{true}}" value="{{$FichaTecnica->Usos}}"
                                        isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>

                                    <div class="form-group row g-3">
                                        <label for="EstadoCrecimiento"
                                            class="col-md-4 col-form-label text-md-left">{{ __('Estado de crecimiento') }}</label>

                                        <div class="col-md-8">

                                            <select class="custom-select" id="Porte" name="Porte">
                                                @if (is_null($FichaTecnica->Porte))
                                                <option selected disabled value="">Sin Estado de porte registrado</option>
                                                @else
                                                @if ($FichaTecnica->Porte=="Chico")
                                                <option selected  value="Chico">Chico</option>
                                                @else
                                                @if ($FichaTecnica->Porte=="Mediano")
                                                <option selected  value="Mediano">Mediano</option>
                                                @else
                                                <option selected  value="Grande">Grande</option>
                                                @endif
                                                @endif
                                                @endif
                                            </select>

                                        </div>
                                    </div>


                                    <x-typeInput labelFor="ClimaN" :isRequiered="true" typeInput="text"
                                        label="Clima en hábitad  natural" isTextArea="true" haveValue="{{true}}"
                                        value="{{$FichaTecnica->Clima}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>

                                    <x-typeInput labelFor="Requerimientos" :isRequiered="true" typeInput="text"
                                        label="Requerimientos de la especie" isTextArea="true" haveValue="{{true}}"
                                        value="{{$FichaTecnica->RequerimientosE}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput labelFor="ServicioAmbiental" :isRequiered="true" typeInput="text"
                                        label="Servicios ambientales" isTextArea="true" haveValue="{{true}}"
                                        value="{{$FichaTecnica->ServiciosAmb}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>
                                    <x-typeInput labelFor="AmenazasR" :isRequiered="true" typeInput="text"
                                        label="Amenazas y riesgos" isTextArea="true" haveValue="{{true}}"
                                        value="{{$FichaTecnica->AmenazasRiesgos}}" isReadOnly="{{boolval($isReO)}}">
                                    </x-typeInput>

                                </div>
                           
                        </div>
                    </div>
                </div>





                <div class="form-row justify-content-between ">



                    <div class="container mb-3">
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary btn-lg">Confirmar</button>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>


    @endsection

</body>

</html>



@push('scripts')
<script>
    var app = new Vue({
  el: '#appp',
  data: {
    archivos:[],
    NCientifico:'',
    Nombres:[],
    NombreC:'',
    Referencias:[]
  },
  mounted:
  function() {
    this.$nextTick(
          function () {
                this.archivos.push(
                    {
                    "imagen":'{{$FichaTecnica->Url_PC}}',
                    "nombre":'Archivo1',
                    "parteP":'Planta completa',   
                    "ban":false
                },
                {
                    "imagen":'{{$FichaTecnica->Url_F}}',
                    "nombre":'Archivo2',
                    "parteP":'Follaje',   
                    "ban":false
                },
                {
                    "imagen":'{{$FichaTecnica->Url_H}}',
                    "nombre":'Archivo3',
                    "parteP":'Hojas',  
                    "ban":false 
                },
                {
                    "imagen":'{{$FichaTecnica->Url_FL}}',
                    "nombre":'Archivo4',
                    "parteP":'Flores',  
                    "ban":false 
                },
                {
                    "imagen":'{{$FichaTecnica->Url_FR}}',
                    "nombre":'Archivo5',
                    "parteP":'Frutos', 
                    "ban":false  
                },
                {
                    "imagen":'{{$FichaTecnica->Url_S}}',
                    "nombre":'Archivo6',
                    "parteP":'Semillas',  
                    "ban":false 
                },
                {
                    "imagen":'{{$FichaTecnica->Url_T}}',
                    "nombre":'Archivo7',
                    "parteP":'Tronco',  
                    "ban":false 
                },
                {
                    "imagen":'{{$FichaTecnica->Url_R}}',
                    "nombre":'Archivo8',
                    "parteP":'Raíces',  
                    "ban":false 
                }
                );
    
  
  
    })
      
  },
  methods:{
    Ncientifico:function(){
        this.Nombres.map((n) => {
            if(document.getElementById('NombreC').value==n.id){
                this.NCientifico=n.NombreC
            }
        })
    },
    cargarImagen: function(e,index){
        let t = this;
        var input = document.getElementById('fileImg' +index);
        
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          
          t.archivos[index].imagen =  e.target.result;
          t.archivos[index].ban=true;

      }
     
      reader.readAsDataURL(input.files[0]);
    }
    }

  }
 
})

</script>

@endpush