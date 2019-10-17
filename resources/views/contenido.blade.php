
@extends("theme/$theme/layout")

@section('contenido')

     <template v-if="menu==0">
          <inicio :enlace="enlace"></inicio>
     </template>

     <template v-if="menu==1">
          <empresa :enlace="enlace"></empresa>
     </template>

     <template v-if="menu==2">
          <usuario :enlace="enlace"></usuario>
     </template>

     <template v-if="menu==3">
          <cliente  :enlace="enlace"></cliente>
     </template>

     <template v-if="menu==4">
          <proveedor  :enlace="enlace"></proveedor>
     </template>

     <template v-if="menu==5">
          <almacen  :enlace="enlace"></almacen>
     </template>

     <template v-if="menu==6">
          <ingreso  :enlace="enlace"></ingreso>
     </template>


     <template v-if="menu==7">
          <venta :enlace="enlace"></venta>
     </template>

     <template v-if="menu==8">
          <admingreso :enlace="enlace"></admingreso>
     </template>

     <template v-if="menu==9">
          <admventa :enlace="enlace"></admventa>
     </template>


@endsection