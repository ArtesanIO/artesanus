$(document).ready(function(){

    var ordenesColeccion;

    $('.btn-add').click(function(){

        ordenesColeccion = $('.collections');

        ordenesColeccion.data('index');

        addOrdenForm(ordenesColeccion);

    });

    function addOrdenForm(ordenesColeccion){
      var prototype = ordenesColeccion.data('prototype');

      var index = ordenesColeccion.data('index');
      var nuevaOrden = prototype.replace(/__name__/g, index);

      ordenesColeccion.data('index', index + 1);

      $('.collections').append(nuevaOrden);
    }

    $('.btn-delete').click(function(){
        event.preventDefault();
        son = $(this).parent();
        parent = son.parent();

        parent.remove();
    });

});
