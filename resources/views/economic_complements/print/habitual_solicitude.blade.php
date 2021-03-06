@extends('globalprint.wkhtml')

@section('formnumber')
Formulario Nº 4
@endsection

@section('content')
<style>
  body{
    font-size: 13px;
  }
</style>
<div id="project">
 <strong>Señor (a) </strong><br />
 <strong>DIRECTOR (A) GENERAL EJECUTIVO</strong><br />
 <strong>MUTUAL DE SERVICIOS AL POLICÍA</strong><br />
 Presente.-<br /><br />
 <p><strong>REF: SOLICITUD PAGO COMPLEMENTO ECONÓMICO {!! strtoupper($economic_complement->economic_complement_procedure->semester) !!} SEMESTRE DE LA GESTIÓN {!! strtoupper(Util::getYear($economic_complement->economic_complement_procedure->year)) !!} COMO BENEFICIARIO HABITUAL</strong></p><br />

 <p>Distinguido (a) Director (a): </p>
 <p align="justify">La presente tiene por objeto solicitar a su autoridad pueda instruir por la unidad correspondiente hacerme el <strong>&nbsp;&nbsp; PAGO DEL BENEFICIO DEL COMPLEMENTO ECONÓMICO DEL {!! strtoupper($economic_complement->economic_complement_procedure->semester) !!} SEMESTRE DE LA GESTIÓN {!! strtoupper(Util::getYear($economic_complement->economic_complement_procedure->year)) !!}, </strong> en mi calidad de beneficiario habitual.</p>
 <p>Para tal efecto, adjunto los requisitos exigidos de acuerdo al siguiente detalle:</p>
 <div class="title2"><strong class="code">DOC - {!! $doc_number !!} </strong><strong class="code">Trámite Nº: {!! $economic_complement->code !!} </strong><strong class="code">Nº Afiliado: {!! $affiliate->id !!} </strong></div>
 <table class="table" style="width:100%; font-size:14px">
     <tr>
       <td colspan="6" class="grand info_title">
         INFORMACIÓN DEL BENEFICIARIO
       </td>
     </tr>
     <tr >
       <td colspan="1"><strong>NOMBRE:</strong></td><td colspan="5" nowrap>{!! $eco_com_applicant->getFullName() !!}</td>
     </tr>
     <tr>
       <td><strong>C.I.:</strong></td><td nowrap>{!! $eco_com_applicant->identity_card !!} {{$eco_com_applicant->city_identity_card->first_shortened ?? ''}}</td>
       <td><strong>FECHA DE NAC.:</strong></td><td> {!! $eco_com_applicant->getShortBirthDate() !!}</td>
       <td><strong>EDAD:</strong></td><td>{!! $eco_com_applicant->getAge() !!} AÑOS</td>
     </tr>
     <tr>
       <td><strong>TELÉFONO:</strong></td>
       <td>
         {!! explode(',',$eco_com_applicant->phone_number)[0] !!}<br/>
       </td>
       <td><strong>CELULAR:</strong></td>
       <td>
         {!! explode(',',$eco_com_applicant->cell_phone_number)[0] !!}<br/>
       </td>
       <td><strong>LUGAR DE NAC.:</strong></td>
       <td>{!! $eco_com_applicant->city_birth->second_shortened ?? '' !!}</td>
     </tr>
   </table>
   @if($economic_complement->economic_complement_modality->economic_complement_type->id > 1)
  <table class="table" style="width:100%; font-size:14px">
    <tr>
      <td colspan="8" class="grand info_title">
        INFORMACIÓN DEL CAUSAHABIENTE
      </td>
    </tr>
    <tr>
      <td colspan="1"><strong>NOMBRE:</strong></td><td colspan="2" nowrap>{!! $affiliate->getFullNamePrintTotal() !!}</td>
      <td><strong>GRADO:</strong></td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td>
      <td><strong>CATEGORÍA:</strong></td><td>{!! $economic_complement->category->getPercentage() !!}</td>
    </tr>
    <tr>
      <td><strong>C.I.:</strong></td><td nowrap colspan="2">  {!! $affiliate->identity_card !!} {!! $affiliate->city_identity_card->first_shortened ?? '' !!}</td><td><strong>FECHA DE NAC.:</strong></td><td> {!! $affiliate->getShortBirthDate() !!}</td><td><strong>EDAD:</strong></td><td>{!! $affiliate->getAge() !!} AÑOS</td>
    </tr>
  </table>
  @endif
 {{--Información del trámite--}}
 <table style="font-size:14px">
   <tr>
     <td colspan="6" class="grand info_title">INFORMACIÓN DEL TRÁMITE</td>
   </tr>
   <tr>
      @if($economic_complement->economic_complement_modality->economic_complement_type->id > 1)
      <td colspan="2"><strong>TIPO DE PRESTACIÓN:</strong></td>
      <td colspan="4">{{ $economic_complement->economic_complement_modality->shortened ?? '' }}</td> 
    @else
      <td><strong>TIPO DE PRESTACIÓN:</strong></td><td>{{ $economic_complement->economic_complement_modality->shortened ?? '' }}</td>
      <td><strong>GRADO:</strong></td><td>{!! $economic_complement->degree->shortened ?? '' !!}</td>
      <td><strong>CATEGORÍA:</strong></td><td>{!! $economic_complement->category->getPercentage() !!}</td>
    @endif
   </tr>
   <tr>
     <td><strong>REGIONAL:</strong></td><td>{!! $economic_complement->city->name !!}</td>    
     <td><strong>GESTIÓN:</strong></td><td> {!! $economic_complement->getYear() !!}</td>
     <td><strong>SEMESTRE:</strong></td><td>{!! $economic_complement->getSemester()!!}/{!! $economic_complement->getYear() !!}</td>
   </tr>
   <tr>
     <td><strong>ENTE GESTOR:</strong></td><td>{!! $affiliate->pension_entity->name ?? '' !!}</td>
     <td><strong>TIPO DE TRÁMITE: </strong></td><td>{!! strtoupper($economic_complement->reception_type) !!}</td>    
     <td><strong>FECHA DE RECEPCIÓN:</strong></td><td>{!! $economic_complement->getReceptionDate() !!}</td>
   </tr>
 </table>

 <table>
            <tr>
              <th class="grand bold">N°</th>
              <th class="grand bold">REQUISITOS</th>
              <th class="grand bold">ESTADO</th>

            </tr>
            @foreach($eco_com_submitted_document as $i=>$item)
            <tr>
                <td><center>{!! $i+1 !!}</center></td>
                <td>{!! $item->economic_complement_requirement->name !!}.</td>
                @if ($item->status == 1)
                    <td class="info" style='text-align:center;'>
                      <img class="circle" src="{{ asset('img/check.png') }}" >
                    </td>
                @else
                  <td class="info" style='text-align:center;'>
                    <img class="circle" src="{{ asset('img/uncheck.png') }}" >
                  
                  </td>
                @endif
            </tr>
            @endforeach
</table>
 <p>Sin otro particular me despido de usted muy atentamente. </p>
 <table>
  <tr>
    <th class="no-border" style="width:33%">&nbsp;</th>
    <th class="info" style="border: 0px;text-align:center;"><p>&nbsp;</p><br>
      ----------------------------------------------------<br>
      <strong>{!! $eco_com_applicant->getFullName() ?? '' !!}<br />C.I.: {!! $eco_com_applicant->identity_card !!} {!! isset($eco_com_applicant->city_identity_card->first_shortened) ?  $eco_com_applicant->city_identity_card->first_shortened.'.' : '' !!} <br /> Teléfono: {!! $eco_com_applicant->getPhone() !!}</strong>
    </th>
    <th class="no-border"> <div class="info" style="border: 1px solid  #3c3c3c!IMPORTANT;text-align:center;width: 100%;"><p>&nbsp;</p><br><br><br><br></div><br><span class="info" style="border: 0px;text-align:center;">Impresión Digital Pulgar Derecho</span></th>
  </tr>
</table>
</div>
<p align="justify"><strong class="size-10">Los datos insertos en la presente solicitud son plena responsabilidad del solicitante, mismos que podrán ser verificados mediante SERECI, SEGIP y otras instancias de ser necesario.</strong></p>
@endsection
